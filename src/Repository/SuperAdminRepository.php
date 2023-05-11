<?php

namespace App\Repository;

use App\Entity\SuperAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SuperAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuperAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuperAdmin[]    findAll()
 * @method SuperAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuperAdminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuperAdmin::class);
    }

//    /**
//     * @return SuperAdmin[] Returns an array of SuperAdmin objects
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
    public function findOneBySomeField($value): ?SuperAdmin
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
