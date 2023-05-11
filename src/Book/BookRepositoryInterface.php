<?php

namespace App\Book;

use App\Entity\Book;

interface BookRepositoryInterface
{

    /**
     * Permet de retourner un book sur la
     * base de son identifiant unique.
     * @param $id
     * @return Book|null
     */
    public function find($id): ?Book;

    /**
     * Retourne la liste de tous les books
     * @return iterable|null
     */
    public function findAll(): ?iterable;

    /**
     * Retourne les 5 derniers books depuis
     * l'ensemble de nos sources...
     * @return iterable|null
     */
    public function findLastFiveBooks(): ?iterable;

    /**
     * Retourne le nombre d'éléments de chaque source.
     * @return int
     */
    public function count(): int;

    # public function findBy();
    # public function findOneBy();
}
