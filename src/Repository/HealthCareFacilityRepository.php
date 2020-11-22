<?php

namespace App\Repository;

use App\Entity\HealthCareFacility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HealthCareFacility|null find($id, $lockMode = null, $lockVersion = null)
 * @method HealthCareFacility|null findOneBy(array $criteria, array $orderBy = null)
 * @method HealthCareFacility[]    findAll()
 * @method HealthCareFacility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HealthCareFacilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HealthCareFacility::class);
    }

    public function findFacility($search=null, $healthcare=null)
    {
        $qb=$this->createQueryBuilder('f');
        if($search)
            $qb->andWhere("f.name  LIKE '%".$search."%'");
        if($search)
            $qb->andWhere("f.facility = val1: ")
            ->setParameter('val1', $healthcare);
            return 
            $qb->orderBy('f.id', 'ASC')
            ->getQuery();
    }

    // /**
    //  * @return HealthCareFacility[] Returns an array of HealthCareFacility objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HealthCareFacility
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
