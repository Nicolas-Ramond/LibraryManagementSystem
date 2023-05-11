<?php

namespace App\Book;

use App\Controller\HelperTrait;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

class BookRequestHandler
{
    use HelperTrait;

    private $em;
    private $assetsDirectory;
    private $bookFactory;
    private $packages;
    private $workflows;

    /**
     * BookRequestHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param BookFactory $bookFactory
     * @param string $assetsDirectory
     * @param Registry $workflows
     * @param Packages $packages
     * @internal param Package $package
     * @internal param $em
     */
    public function __construct(
        EntityManagerInterface $entityManager,
                                BookFactory $bookFactory,
                                string $assetsDirectory,
                                Registry $workflows,
                                Packages $packages
    ) {
        $this->em = $entityManager;
        $this->bookFactory = $bookFactory;
        $this->assetsDirectory = $assetsDirectory;
        $this->packages = $packages;
        $this->workflows = $workflows;
    }

    public function handle(BookRequest $request): ?Book
    {

        # Traitement de l'upload de mon image
        /** @var UploadedFile $image */
        $image = $request->getFeaturedImage();

        # Nom du Fichier
        $fileName = rand(0, 100).$this->slugify($request->getTitle()) . '.'
            . $image->guessExtension();

        $image->move(
            $this->assetsDirectory,
            $fileName
        );

        # Mise à jour de l'image
        $request->setFeaturedImage($fileName);

        # Mise à jour du slug
        $request->setSlug($this->slugify($request->getTitle()));

        # Récupération du Workflow
        $workflow = $this->workflows->get($request);

        # Permet de voir les transitions possibles (Changement de Status)
        # dd($workflow->getEnabledTransitions($request));

        try {

            # Changement du Workflow
            $workflow->apply($request, 'to_review');

            # Appel à notre Factory
            $book = $this->bookFactory->createFromBookRequest($request);

            # Insertion en BDD
            $this->em->persist($book);
            $this->em->flush();

            return $book;
        } catch (LogicException $e) {

            # Transition non autorisé
            return null;
        }
    }

//    public function prepareBookFromRequest(Book $book): BookRequest
//    {
//        return BookRequest::createFromBook($book, $this->packages, $this->assetsDirectory);
//    }
}
