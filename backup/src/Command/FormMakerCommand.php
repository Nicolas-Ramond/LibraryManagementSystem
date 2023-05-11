<?php

namespace App\Command;

use App\Service\Maker\View\DoctrineHelper;
use App\Service\Maker\View\Generator;
use App\Service\Maker\View\Str;
use App\Service\Maker\View\Validator;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Console\Style\SymfonyStyle;


class ViewMakerCommand extends Command
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    private $entityClass;
    /**
     * @var Generator
     */
    private $generator;
    /**
     * @var DoctrineHelper
     */
    private $doctrineHelper;

    private $doctrineEntities = [];

    /**
     * @var SymfonyStyle
     */
    private $io;

    public function __construct(
        EntityManagerInterface $entityManager
        , Generator $generator
        , DoctrineHelper $doctrineHelper
        , $name = null
    )
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->generator = $generator;
        $this->doctrineHelper = $doctrineHelper;

        $entities = [];
        try {
            $entitiesTemp = $this->entityManager->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
            foreach ( $entitiesTemp as $entity ) $entities[] = str_replace( 'App\\Entity\\', '', $entity );
        } catch (ORMException $e) {
        }

        $this->doctrineEntities = $entities;
    }

    protected function configure()
    {
        $this
            ->setName('app:make-form')
            ->setDescription('Creates Form for Doctrine entity class')
            ->setHelp(file_get_contents(__DIR__.'/help/MakeCrud.txt'))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->io->title('Bienvenu dans le génarateur de forms des controllers');

        $question = new Question('Bienvenu dans le génarateur de forms des controllers');
        $question->setAutocompleterValues($this->doctrineEntities);

        $value = $this->io->askQuestion($question);

//        $input->setArgument('entity-class', $value);
        $this->entityClass = $value;

        $this->generate();
    }

    public function generate()
    {
        $entityClassDetails = $this->generator->createClassNameDetails(
            Validator::entityExists($this->entityClass, $this->doctrineEntities),
            ''
        );

        $entityDoctrineDetails = $this->doctrineHelper->createDoctrineDetails($entityClassDetails->getFullName());

        $repositoryVars = [];

        if (null !== $entityDoctrineDetails->getRepositoryClass()) {
            $repositoryClassDetails = $this->generator->createClassNameDetails(
                '\\'.$entityDoctrineDetails->getRepositoryClass(),
                'Repository\\',
                'Repository'
            );

            $repositoryVars = [
                'repository_full_class_name' => $repositoryClassDetails->getFullName(),
                'repository_class_name' => $repositoryClassDetails->getShortName(),
                'repository_var' => lcfirst(Inflector::singularize($repositoryClassDetails->getShortName())),
            ];
        }

        $controllerClassDetails = $this->generator->createClassNameDetails(
            $entityClassDetails->getRelativeNameWithoutSuffix(),
            'Controller\\',
            'Controller'
        );

        $iterator = 0;
        do {
            $formClassDetails = $this->generator->createClassNameDetails(
                $entityClassDetails->getRelativeNameWithoutSuffix().($iterator ?: ''),
                'Form\\',
                'Type'
            );
            ++$iterator;
        } while (class_exists($formClassDetails->getFullName()));

        $entityVarPlural = lcfirst(Inflector::pluralize($entityClassDetails->getShortName()));
        $entityVarSingular = lcfirst(Inflector::singularize($entityClassDetails->getShortName()));

        $entityTwigVarPlural = Str::asTwigVariable($entityVarPlural);
        $entityTwigVarSingular = Str::asTwigVariable($entityVarSingular);

        $routeName = Str::asRouteName($controllerClassDetails->getRelativeNameWithoutSuffix());

        $this->generator->generateClass(
            $formClassDetails->getFullName(),
            'form/Type.tpl.php',
            [
                'bounded_full_class_name' => $entityClassDetails->getFullName(),
                'bounded_class_name' => $entityClassDetails->getShortName(),
                'form_fields' => $entityDoctrineDetails->getFormFields(),
            ]
        );

        $templatesPath = Str::asFilePath($controllerClassDetails->getRelativeNameWithoutSuffix());

        $templates = [
            '_delete_form' => [
                'route_name' => $routeName,
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
            ],
            '_form' => [],
            'edit' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'route_name' => $routeName,
            ],
            'index' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_twig_var_plural' => $entityTwigVarPlural,
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
            ],
            'new' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'route_name' => $routeName,
            ],
            'show' => [
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_twig_var_singular' => $entityTwigVarSingular,
                'entity_identifier' => $entityDoctrineDetails->getIdentifier(),
                'entity_fields' => $entityDoctrineDetails->getDisplayFields(),
                'route_name' => $routeName,
            ],
        ];

        foreach ($templates as $template => $variables) {
            try {
                $this->generator->generateFile(
                    'templates/backend/' . $templatesPath . '/' . $template . '.html.twig',
                    'crud/templates/' . $template . '.tpl.php',
                    $variables
                );
            } catch (\Exception $e) {
            }
        }

        $this->generator->writeChanges();

        $this->writeSuccessMessage($this->io);

        $this->io->text(sprintf('Next: Check your new CRUD by going to <fg=yellow>%s/</>', Str::asRoutePath($controllerClassDetails->getRelativeNameWithoutSuffix())));
    }

    /**
     * {@inheritdoc}
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            Route::class,
            'annotations'
        );

        $dependencies->addClassDependency(
            AbstractType::class,
            'form'
        );

        $dependencies->addClassDependency(
            Validation::class,
            'validator'
        );

        $dependencies->addClassDependency(
            TwigBundle::class,
            'twig-bundle'
        );

        $dependencies->addClassDependency(
            DoctrineBundle::class,
            'orm-pack'
        );

        $dependencies->addClassDependency(
            CsrfTokenManager::class,
            'security-csrf'
        );
    }


    protected function writeSuccessMessage(SymfonyStyle $io)
    {
        $io->newLine();
        $io->writeln(' <bg=green;fg=white>          </>');
        $io->writeln(' <bg=green;fg=white> Success! </>');
        $io->writeln(' <bg=green;fg=white>          </>');
        $io->newLine();
    }
}
