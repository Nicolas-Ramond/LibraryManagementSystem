<?php

namespace App\Service\Book;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlProvider
{
    private $kernel;

    /**
     * YamlProvider constructor.
     * @param $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Récupère les livres depuis le cache
     * et retourne un Tableau de livres.
     * @return iterable
     */
    public function getBooks(): iterable
    {
        $book = unserialize(file_get_contents(
            $this->kernel->getCacheDir() . '/yaml-book.php'
        ));

        return $book['data'];
    }
}
