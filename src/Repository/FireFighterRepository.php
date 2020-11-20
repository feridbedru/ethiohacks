<?php

namespace App\Repository;

use App\Entity\FireFighter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FireFighter|null find($id, $lockMode = null, $lockVersion = null)
 * @method FireFighter|null findOneBy(array $criteria, array $orderBy = null)
 * @method FireFighter[]    findAll()
 * @method FireFighter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FireFighterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FireFighter::class);
    }

    // /**
    //  * @return FireFighter[] Returns an array of FireFighter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FireFighter
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
