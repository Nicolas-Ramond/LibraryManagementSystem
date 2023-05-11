<?php

namespace App\Book;

use App\Book\Source\BookAbstractSource;

interface BookCatalogueInterface extends BookRepositoryInterface
{
    public function addSource(BookAbstractSource $source): void;
    public function setSources(iterable $sources): void;
    public function getSources(): iterable;
}
