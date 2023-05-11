<?php

namespace App\Service\Book;

use App\Entity\Book;
use App\Entity\Booking;
use App\Entity\PBook;
use App\Factory\BookFactory;
use Ovh\Exceptions\InvalidParameterException;
use PhpParser\Node\Expr\Cast\Bool_;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookProvider extends AbstractController
{

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $topNumber
     * @return array
     */
    public function topBooks($topNumber)
    {
            $em = $this->getDoctrine()->getManager();

        $topBooks = $em->getRepository(Book::class)->findTop($topNumber);

        $topBooks = BookFactory::createBooksFromArray($topBooks);

            $this->logger->info('We have contacted the logger: TOP ' . $topNumber . ' of pbooks requested. ');

            return $topBooks;

    }

}
