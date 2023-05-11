<?php

namespace App\Book\Source;

use App\Book\Source\BookAbstractSource;
use App\Entity\Book;
//use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSource extends BookAbstractSource
{
    private $repository;
    private $entity = Book::class;

    /**
     * DoctrineSource constructor.
     * @param $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository($this->entity);
    }

    /**
     * Permet de retourner un livre sur la
     * base de son identifiant unique.
     * @param $id
     * @return Article|null
     */
    public function find($id): ?Book
    {
        return $this->repository->find($id);
    }

    /**
     * Retourne la liste de tous les livres
     * @return iterable|null
     */
    public function findAll(): ?iterable
    {
        return $this->repository->findAll();
    }

    /**
     * Retourne les 5 derniers livres depuis
     * l'ensemble de nos sources...
     * @return iterable|null
     */
    public function findLastFiveBooks(): ?iterable
    {
        return $this->repository->findLastFiveBooks();
    }

    /**
     * Retourne le nombre d'éléments de chaque source.
     * @return int
     */
    public function count(): int
    {
        return $this->repository->findTotalBooks();
    }

    /**
     * Permet de convertir un tableau en Livre.
     * @param iterable $book Un livre sous forme de tableau
     * @return Book|null
     */
    protected function createFromArray(iterable $book): ?Book
    {
        return null;
    }
}
