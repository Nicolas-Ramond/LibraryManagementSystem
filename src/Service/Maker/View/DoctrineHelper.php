<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Maker\View;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use App\Service\Maker\View\Util\ClassNameDetails;
use Doctrine\ORM\ORMException;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Ryan Weaver <ryan@knpuniversity.com>
 * @author Sadicov Vladimir <sadikoff@gmail.com>
 *
// * @internal
 */
final class DoctrineHelper
{
    /**
     * @var string
     */
    private $entityNamespace;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    private $doctrineEntities = [];

    public function __construct(
        EntityManagerInterface $entityManager
        , string $entityNamespace = 'App\\Entity'
    )
    {
        $this->entityNamespace = trim($entityNamespace, '\\');
        $this->entityManager = $entityManager;

        $entities = [];

        try {
            $entitiesTemp = $this->entityManager->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
            foreach ( $entitiesTemp as $entity ) $entities[] = str_replace( 'App\\Entity\\', '', $entity );
        } catch (ORMException $e) {
        }

        $this->doctrineEntities = $entities;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        // this should never happen: we will have checked for the
        // DoctrineBundle dependency before calling this
        if (null === $this->entityManager) {
            throw new \Exception('Somehow the doctrine service is missing. Is DoctrineBundle installed?');
        }

        return $this->entityManager;
    }

    private function isDoctrineInstalled(): bool
    {
        return null !== $this->entityManager;
    }

    public function getEntityNamespace(): string
    {
        return $this->entityNamespace;
    }

    /**
     * @param string $className
     *
     * @return MappingDriver|null
     *
     * @throws \Exception
     */
    public function getMappingDriverForClass(string $className)
    {
        /** @var EntityManagerInterface $em */
        $this->getEntityManager()->find($className);
        $em = $this->getEntityManager()->getManagerForClass($className);

        if (null === $em) {
            throw new \InvalidArgumentException(sprintf('Cannot find the entity manager for class "%s"', $className));
        }

        $metadataDriver = $this->getEntityManager()->getConfiguration()->getMetadataDriverImpl();

        if (!$metadataDriver instanceof MappingDriverChain) {
            return $metadataDriver;
        }

        foreach ($metadataDriver->getDrivers() as $namespace => $driver) {
            if (0 === strpos($className, $namespace)) {
                return $driver;
            }
        }

        return $metadataDriver->getDefaultDriver();
    }

    public function getEntitiesForAutocomplete(): array
    {
        $entities = [];

        if ($this->isDoctrineInstalled()) {
            $allMetadata = $this->getMetadata();

            /* @var ClassMetadata $metadata */
            foreach (array_keys($allMetadata) as $classname) {
                $entityClassDetails = new ClassNameDetails($classname, $this->entityNamespace);
                $entities[] = $entityClassDetails->getRelativeName();
            }
        }

        return $this->doc;
    }

    /**
     * @param string|null $classOrNamespace
     * @param bool        $disconnected
     *
     * @return array|ClassMetadata
     * @throws \Exception
     */
    public function getMetadata(string $classOrNamespace = null, bool $disconnected = false)
    {
        $metadata = [];

        /** @var EntityManagerInterface $em */
//        foreach ($this->getEntityManager()->getManagers() as $em) {
//            if ($disconnected) {
//                $cmf = new DisconnectedClassMetadataFactory();
//                $cmf->setEntityManager($em);
//            } else {
//                $cmf = $em->getMetadataFactory();
//            }
//
//            foreach ($cmf->getAllMetadata() as $m) {
//                if (null === $classOrNamespace) {
//                    $metadata[$m->getName()] = $m;
//                } else {
//                    if ($m->getName() === $classOrNamespace) {
//                        return $m;
//                    }
//
//                    if (0 === strpos($m->getName(), $classOrNamespace)) {
//                        $metadata[$m->getName()] = $m;
//                    }
//                }
//            }
//        }

        return $this->getEntityManager()->getClassMetadata($classOrNamespace);

        return $metadata;
    }

    /**
     * @param string $entityClassName
     *
     * @return EntityDetails|null
     */
    public function createDoctrineDetails(string $entityClassName)
    {
        $metadata = $this->getMetadata($entityClassName);

        if ($metadata instanceof ClassMetadata) {
            return new EntityDetails($metadata);
        }

        return null;
    }
}