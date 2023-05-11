<?php

namespace App\Book;

use App\Controller\HelperTrait;
use App\Entity\Book;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BookRequestUpdateHandler
{
    use HelperTrait;

    private $em;
    private $assetsDirectory;

    public function __construct(
        ObjectManager $manager,
                                string $assetsDirectory
    ) {
        $this->em = $manager;
        $this->assetsDirectory = $assetsDirectory;
    }

    public function handle(BookRequest $bookRequest, Book $book)
    {
        # Traitement de l'upload de mon image
        /** @var UploadedFile $image */
        $image = $bookRequest->getFeaturedImage();

        /*
         * Todo : Pensez a supprimer l'ancienne image sur le FTP.
         */
        if (null !== $image) {
            # Nom du Fichier
            $fileName = rand(0, 100).$this->slugify($bookRequest->getTitle()) . '.'
                . $image->guessExtension();

            $image->move(
                $this->assetsDirectory,
                $fileName
            );

            # Mise à jour de l'image
            $bookRequest->setFeaturedImage($fileName);
        } else {
            $bookRequest->setFeaturedImage($book->getFeaturedImage());
        }

        # Mise à jour du contenu
        $book->update(
            $bookRequest->getTitle(),
            $this->slugify($bookRequest->getTitle()),
            $bookRequest->getContent(),
            $bookRequest->getFeaturedImage(),
            $bookRequest->getSpecial(),
            $bookRequest->getSpotlight(),
            $bookRequest->getCreatedDate(),
            $bookRequest->getCategory()
        );

        # Sauvegarde en BDD
        $this->em->flush();

        # On retourne notre Book
        return $book;
    }
}
