<?php

namespace App\Repository;

use App\Entity\QuotaDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuotaDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuotaDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuotaDetail[]    findAll()
 * @method QuotaDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotaDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuotaDetail::class);
    }

    // /**
    //  * @return QuotaDetail[] Returns an array of QuotaDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuotaDetail
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
