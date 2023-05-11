<?php

namespace App\Elasticsearch;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Elastica\Client;
use Elastica\Document;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BookingIndexer
{
    private $client;
    private $bookingRepository;
    private $router;

    public function __construct(Client $client, BookingRepository $bookingRepository, UrlGeneratorInterface $router)
    {
        $this->client = $client;
        $this->bookingRepository = $bookingRepository;
        $this->router = $router;
    }

    public function buildDocument(Booking $booking)
    {
        return new Document(
            $booking->getId(), // Manually defined ID
            [
                'Book_id' => $booking->getPBook()->getBook()->getId(),
                'Book_isbn' => $booking->getPBook()->getBook()->getIsbn(),
                'Book_title' => $booking->getPBook()->getBook()->getTitle(),
                'Book_author' => $booking->getPBook()->getBook()->getAuthor()->getLastName(),
                'Subcategory_book' => $booking->getPBook()->getBook()->getSubCategory()->getName(),
                'Member_id' => $booking->getMember()->getId(),
                'Member_firstname' => $booking->getMember()->getFirstName(),
                'Member_lastname' => $booking->getMember()->getLastName(),
                'Member_email' => $booking->getMember()->getEmail(),
                'Booking_startdate' => $booking->getStartDate()->format('Y-m-d'),
                'Booking_enddate' => $booking->getEndDate()->format('Y-m-d'),
                'PBook_id' => $booking->getPBook()->getId(),
                'Member_address' => $booking->getMember()->getTown(),
            ],
            'biblio' // Types are deprecated, to be removed in Elastic 7
        );
    }

    public function indexAllDocuments($indexName)
    {
        $allBookings = $this->bookingRepository->findAll();
        $index = $this->client->getIndex($indexName);

        $documents = [];
        foreach ($allBookings as $booking) {
            $documents[] = $this->buildDocument($booking);
        }

        $index->addDocuments($documents);
        $index->refresh();
    }
}
