<?php

namespace App\Booking;

use App\Controller\HelperTrait;
use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Exception\LogicException;

class BookingRequestHandler
{
    use HelperTrait;


    /**
     * @var BookingFactory $bookingFactory
     */
    private $bookingFactory;
    private $em;

//    private $em, $assetsDirectory, $bookingFactory, $packages, $workflows;

    /**
     * BookingRequestHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param BookingFactory $bookingFactory
     * @internal param $em
     */
    public function __construct(EntityManagerInterface $entityManager, BookingFactory $bookingFactory)
    {
        $this->em = $entityManager;
        $this->bookingFactory = $bookingFactory;
    }

    /**
     * @param BookingRequest $request
     * @param Booking $booking
     * @return Booking|null
     */
    public function handle(BookingRequest $request): ?Booking
    {

        # Permet de voir les transitions possibles (Changement de Status)
        # dd($workflow->getEnabledTransitions($request));

//        dd($request);

        try {


            # Appel à notre Factory
            $booking = $this->bookingFactory->createFromBookingRequest($request);

            # Insertion en BDD
            $this->em->persist($booking);
            $this->em->flush();

            return $booking;
        } catch (LogicException $e) {

            # Transition non autorisé
            return null;
        }
    }

//    public function prepareBookingFromRequest(Booking $booking): BookingRequest
//    {
//        return BookingRequest::createFromBooking($booking, $this->packages, $this->assetsDirectory);
//    }
}
