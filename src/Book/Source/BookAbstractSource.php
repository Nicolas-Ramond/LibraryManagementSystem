<?php

namespace App\Book\Source;

use App\Book\BookCatalogue;
use App\Book\BookRepositoryInterface;
use App\Entity\Book;

abstract class BookAbstractSource implements BookRepositoryInterface
{
    protected $catalogue;

    /**
     * @param BookCatalogue $catalogue
     */
    public function setCatalogue(BookCatalogue $catalogue): void
    {
        $this->catalogue = $catalogue;
    }

    /**
     * Permet de convertir un tableau en Book.
     * @param iterable $Book Un Book sous forme de tableau
     * @return Book|null
     */
    abstract protected function createFromArray(iterable $Book): ?Book;
}
