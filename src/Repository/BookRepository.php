<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraints\Count;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Récupère les 5 derniers livres.
     *
     * @return mixed
     */
    public function findLastFiveBooks()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les suggestions de livres.
     */
    public function findBooksSuggestions($idbook, $idcategorie)
    {
        return $this->createQueryBuilder('a')
            // Where pour la catégorie
            ->where('a.category = :category_id')
            ->setParameter('category_id', $idcategorie)
            // Where pour l'article
            ->andWhere('a.id != :book_id')
            ->setParameter('book_id', $idbook)
            // Par ordre décroissant
            ->orderBy('a.id', 'DESC')
            // Maximum 3
            ->setMaxResults(3)
            // On finalise
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les livres en Spotlight.
     *
     * @return mixed
     */
    public function findSpotlightBooks()
    {
        return $this->createQueryBuilder('a')
            ->where('a.spotlight = 1')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les livres "special" de la sidebar.
     *
     * @return mixed
     */
    public function findSpecialBooks()
    {
        return $this->createQueryBuilder('a')
            ->where('a.special = 1')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * Compte le nombre de livres dans la BDD.
     *
     * @return int|mixed
     */
    public function findTotalBooks()
    {
            return $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->getQuery()
                ->getSingleScalarResult();
    }

    /**
     * Récupérer tous les livres d'un Auteur par Statut.
     *
     * @param int    $idAuthor
     * @param string $status   Status du livre
     *
     * @return \Doctrine\ORM\QueryBuilder
     *
     * @internal param int $idauteur ID de l'Auteur
     */
    public function findAuthorBooksByStatus(int $idAuthor, string $status)
    {
        return $this->createQueryBuilder('a')
            ->where('a.user = :author_id')
            ->setParameter('author_id', $idAuthor)
            ->andWhere('a.status LIKE :status')
            ->setParameter('status', "%$status%")
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupérer les livres par Statut.
     *
     * @param string $status
     *
     * @return mixed
     */
    public function findBooksByStatus(string $status)
    {
        return $this->createQueryBuilder('a')
            ->where('a.status LIKE :status')
            ->setParameter('status', "%$status%")
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Compter le nombre de livres d'un Auteur par Statut.
     *
     * @param int    $idAuthor
     * @param string $status
     *
     * @return mixed
     */
    public function countAuthorBooksByStatus(int $idAuthor, string $status)
    {
            return $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->where('a.user = :author_id')
                ->setParameter('author_id', $idAuthor)
                ->andWhere('a.status LIKE :status')
                ->setParameter('status', "%$status%")
                ->getQuery()
                ->getSingleScalarResult();
    }

    /** Compter les livres par statut
     * @param string $status
     *
     * @return int|mixed
     */
    public function countBooksByStatus(string $status)
    {
            return $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->where('a.status LIKE :status')
                ->setParameter('status', "%$status%")
                ->getQuery()
                ->getSingleScalarResult();
    }

    public function findTop($topNumber): array
    {

            $myQuery = $this->createQueryBuilder('book')
                ->join('book.pBooks', 'pbook')
                ->join('pbook.bookings', 'booking')
                ->join('book.image', 'image')
                ->addSelect('COUNT(book.id)')
                ->addSelect('image')
                ->groupBy('book.id')
                ->orderBy('COUNT(book.id)')
                ->setMaxResults($topNumber);
            ;

            return $myQuery
                ->getQuery()
                ->getArrayResult();

    }
}
