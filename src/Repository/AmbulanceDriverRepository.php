<?php

namespace App\Repository;

use App\Entity\AmbulanceDriver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AmbulanceDriver|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmbulanceDriver|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmbulanceDriver[]    findAll()
 * @method AmbulanceDriver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmbulanceDriverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmbulanceDriver::class);
    }

    // /**
    //  * @return AmbulanceDriver[] Returns an array of AmbulanceDriver objects
    //  */
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
    public function findOneBySomeField($value): ?AmbulanceDriver
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
