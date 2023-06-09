<?php

namespace App\Repository;

use App\Entity\Librarian;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Librarian|null find($id, $lockMode = null, $lockVersion = null)
 * @method Librarian|null findOneBy(array $criteria, array $orderBy = null)
 * @method Librarian[]    findAll()
 * @method Librarian[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiberianRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Librarian::class);
    }

//    /**
//     * @return Librarian[] Returns an array of Librarian objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Librarian
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
