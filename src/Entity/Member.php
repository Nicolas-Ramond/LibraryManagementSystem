<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 *
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member extends User
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="member")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MemberEBook", mappedBy="member", orphanRemoval=true)
     */
    private $memberEBooks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MemberSubscription", mappedBy="member", orphanRemoval=true)
     */
    private $memberSubscriptions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MemberType", inversedBy="members")
     * @ORM\JoinColumn(nullable=true)
     */
    private $memberType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $town;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="10")
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="member", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $reservations;

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Member
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param mixed $reservations
     */
    public function setReservations($reservations): void
    {
        $this->reservations = $reservations;
    }

    public function __construct()
    {
        $this->roles = [self::ROLE_MEMBER];
        $this->bookings = new ArrayCollection();
        $this->memberEBooks = new ArrayCollection();
        $this->memberSubscriptions = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param mixed $town
     */
    public function setTown($town): void
    {
        $this->town = $town;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setMember($this);
        }

        return $this;
    }

    public function removebooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getMember() === $this) {
                $booking->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MemberEBook[]
     */
    public function getMemberEBooks(): Collection
    {
        return $this->memberEBooks;
    }

    public function addMemberEBook(MemberEBook $memberEBook): self
    {
        if (!$this->memberEBooks->contains($memberEBook)) {
            $this->memberEBooks[] = $memberEBook;
            $memberEBook->setMember($this);
        }

        return $this;
    }

    public function removeMemberEBook(MemberEBook $memberEBook): self
    {
        if ($this->memberEBooks->contains($memberEBook)) {
            $this->memberEBooks->removeElement($memberEBook);
            // set the owning side to null (unless already changed)
            if ($memberEBook->getMember() === $this) {
                $memberEBook->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MemberSubscription[]
     */
    public function getMemberSubscriptions(): Collection
    {
        return $this->memberSubscriptions;
    }

    public function addMemberSubscription(MemberSubscription $memberSubscription): self
    {
        if (!$this->memberSubscriptions->contains($memberSubscription)) {
            $this->memberSubscriptions[] = $memberSubscription;
            $memberSubscription->setMember($this);
        }

        return $this;
    }

    public function removeMemberSubscription(MemberSubscription $memberSubscription): self
    {
        if ($this->memberSubscriptions->contains($memberSubscription)) {
            $this->memberSubscriptions->removeElement($memberSubscription);
            // set the owning side to null (unless already changed)
            if ($memberSubscription->getMember() === $this) {
                $memberSubscription->setMember(null);
            }
        }

        return $this;
    }

    public function getMemberType(): ?MemberType
    {
        return $this->memberType;
    }

    public function setMemberType(?MemberType $memberType): self
    {
        $this->memberType = $memberType;

        return $this;
    }

    public function __toString()
    {
        return ''.$this->getId();
    }
}
