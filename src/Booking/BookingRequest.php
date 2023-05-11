<?php

namespace App\Booking;

use App\Entity\Booking;
use App\Entity\Member;
use App\Entity\PBook;
use Symfony\Component\Validator\Constraints as Assert;

class BookingRequest
{
    private $id;

    /**
     */
    private $pBook;

    /**
     */
    private $member;

    /**
     */
    private $startDate;

    /**
     */
    private $endDate;

    /**
     */
    private $returnDate;

    /**
     * BookingRequest constructor.
     * @param PBook $pBook
     * @param Member $member
     */
    public function __construct(Pbook $pBook)
    {
        $this->pBook = $pBook;
        $this->startDate = new \DateTime("NOW");
        $this->endDate = new \DateTime("+ 3 weeks");
    }


    /**
     * Créer un BookingRequest depuis un Booking de Entity
     * @param Booking $booking
     * @param Member $member
     * @return BookingRequest
     */
    public static function createFromBooking(Booking $booking, Member $member): self
    {
        $bookingSelf = new self($booking->getPBook(), $member->getId());
        $bookingSelf->id = $booking->getId();
        $bookingSelf->member = $booking->getMember();
        $bookingSelf->startDate = $booking->getStartDate();
        $bookingSelf->endDate = $booking->getEndDate();
        $bookingSelf->returnDate = $booking->getReturnDate();

        return $bookingSelf;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return BookingRequest
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPBook()
    {
        return $this->pBook;
    }

    /**
     * @param mixed $pBook
     * @return BookingRequest
     */
    public function setPBook($pBook)
    {
        $this->pBook = $pBook;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param mixed $member
     * @return BookingRequest
     */
    public function setMember($member)
    {
        $this->member = $member;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     * @return BookingRequest
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     * @return BookingRequest
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    /**
     * @param mixed $returnDate
     * @return BookingRequest
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;
        return $this;
    }
}
