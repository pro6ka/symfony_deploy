<?php

namespace App\Repository;

use App\Entity\FilterType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FilterType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilterType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilterType[]    findAll()
 * @method FilterType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilterTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilterType::class);
    }

    // /**
    //  * @return FilterType[] Returns an array of FilterType objects
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
    public function findOneBySomeField($value): ?FilterType
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
