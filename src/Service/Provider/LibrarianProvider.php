<?php
/**
 * Created by PhpStorm.
 * User: moula
 * Date: 12/08/2018
 * Time: 09:55
 */

namespace App\Service\Provider;


use App\Entity\Book;
use App\Entity\Booking;
use App\Entity\Category;
use App\Entity\Librarian;
use App\Entity\Library;
use App\Entity\Location;
use App\Entity\Member;
use App\Entity\PBook;
use App\Entity\Reservation;
use App\Entity\SubCategory;
use App\Entity\Subscription;
use App\Entity\User;
use App\Repository\BookingRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\LibrarianRepository;
use App\Repository\LibraryRepository;
use App\Repository\LocationRepository;
use App\Repository\MemberRepository;
use App\Repository\PBookRepository;
use App\Repository\ReservationRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\SubscriptionRepository;
use App\Service\Source\Entity\Firebase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LibrarianProvider
{
    /**
     * @var LibraryRepository
     */
    private $libraryRepository;
    /**
     * @var BookRepository
     */
    private $bookRepository;
    /**
     * @var PBookRepository
     */
    private $pbookRepository;
    /**
     * @var BookingRepository
     */
    private $bookingRepository;
    /**
     * @var MemberRepository
     */
    private $memberRepository;
    /**
     * @var LibrarianRepository
     */
    private $librarianRepository;
    /**
     * @var ReservationRepository
     */
    private $reservationRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var LocationRepository
     */
    private $locationRepositoryRepository;
    /**
     * @var SubCategoryRepository
     */
    private $subCategoryRepository;
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var User
     */
    private $user;
    /**
     * @var Firebase
     */
    private $firebase;

    /**
     * Librarian constructor.
     *
     * @param LibraryRepository      $libraryRepository
     * @param BookRepository         $bookRepository
     * @param PBookRepository        $pbookRepository
     * @param BookingRepository      $bookingRepository
     * @param MemberRepository       $memberRepository
     * @param LibrarianRepository    $librarianRepository
     * @param ReservationRepository  $reservationRepository
     * @param CategoryRepository     $categoryRepository
     * @param SubCategoryRepository  $subCategoryRepository
     * @param LocationRepository     $locationRepositoryRepository
     * @param SubscriptionRepository $subscriptionRepository
     * @param Firebase               $firebase
     * @param TokenStorageInterface  $tokenStorage
     */
    public function __construct (
        LibraryRepository $libraryRepository
        , BookRepository $bookRepository
        , PBookRepository $pbookRepository
        , BookingRepository $bookingRepository
        , MemberRepository $memberRepository
        , LibrarianRepository $librarianRepository
        , ReservationRepository $reservationRepository
        , CategoryRepository $categoryRepository
        , SubCategoryRepository $subCategoryRepository
        , LocationRepository $locationRepositoryRepository
        , SubscriptionRepository $subscriptionRepository
        , Firebase $firebase
        , TokenStorageInterface $tokenStorage
    ) {

        $this->libraryRepository = $libraryRepository;
        $this->bookRepository = $bookRepository;
        $this->pbookRepository = $pbookRepository;
        $this->bookingRepository = $bookingRepository;
        $this->memberRepository = $memberRepository;
        $this->librarianRepository = $librarianRepository;
        $this->reservationRepository = $reservationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->locationRepositoryRepository = $locationRepositoryRepository;
        $this->subCategoryRepository = $subCategoryRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->tokenStorage = $tokenStorage;

        $this->user = $tokenStorage->getToken()->getUser();
        $this->firebase = $firebase;
    }

    /**
     * @param Library $library
     * @return Book[]
     */
    public function getBooks(Library $library ) : array {
        return $this->bookRepository->findByLibrary( $library->getId() );
    }

    /**
     * @param Library $library
     * @return Library[]
     */
    public function getLibraries(Library $library ) : array {
        return $this->libraryRepository->findBy( $library->getId() );
    }

    /**
     * @param Library $library
     * @return Librarian[]
     */
    public function getLibrarians( Library $library ) : array {
        return $this->librarianRepository->findBy( ['library' => $library] );
    }

    /**
     * @param Library $library
     * @return PBook[]
     */
    public function getPBooks( Library $library ) : array {
        return $this->pbookRepository->findBy( ['library' => $library] );
    }

    /**
     * @param Library $library
     * @return Booking[]
     */
    public function getBookings( Library $library ) : array {
        return $this->bookingRepository->findBy( ['library' => $library] );
    }

    /**
     * @param Library $library
     * @return Member[]
     */
    public function getMembers( Library $library ) : array {
        return $this->memberRepository->findBy( ['library' => $library] );
    }

    /**
     * @param Library $library
     * @return Reservation[]
     */
    public function getReservations( Library $library ) : array {
        return $this->memberRepository->findBy( ['library' => $library] );
    }

    /**
     * @param Library $library
     * @return Category[]
     */
    public function getCategories( Library $library ) : array {
        return $this->memberRepository->findBy( ['library' => $library] );
    }

    /**
     * @param Library $library
     * @return SubCategory[]
     */
    public function getSubCategories( Library $library ) : array {
        return $this->subCategoryRepository->findBy( ['library' => $library] );
    }

    /**
     * @param Library $library
     * @return Location[]
     */
    public function getLocations( Library $library ) : array {
        return $this->memberRepository->findBy( ['library' => $library] );
    }

    /**
     * @param Library $library
     * @return Subscription[]
     */
    public function getSubscriptions( Library $library ) : array {
        return $this->subscriptionRepository->findBy( ['library' => $library] );
    }

    /**
     * @return Librarian
     */
    public function getLibrarian( ) : Librarian
    {
        /**
         * @var Librarian $librarian
         */
        $librarian = $this->user;
        return $librarian;
    }

    /**
     * @return \App\Service\Source\Entity\Book
     */
    public function getGetBooksFromFirebase( ) : array
    {
        return $this->firebase->getBooks();
    }

    public function getLibrary( $librarian = null )
    {
        $librarian = $librarian ?? $this->getLibrarian();

        return $librarian->getLibrary();
    }
}