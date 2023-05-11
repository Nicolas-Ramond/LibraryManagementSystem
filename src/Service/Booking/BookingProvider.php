<?php

namespace App\Service\Booking;

use App\Entity\Book;
use App\Entity\Booking;
use App\Entity\PBook;
use Ovh\Exceptions\InvalidParameterException;
use PhpParser\Node\Expr\Cast\Bool_;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingProvider extends AbstractController
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
    public function topBookings($topNumber)
    {
            $em = $this->getDoctrine()->getManager();

            $topBookings = $em->getRepository(Book::class)
                ->findPbooktop(10);


            $this->logger->info('We have contacted the logger: TOP ' . $topNumber . ' of pbooks requested. ');

            return $topBookings;

    }

}
