<?php

namespace App\Repository;

use App\Entity\MpollDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MpollDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method MpollDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method MpollDetail[]    findAll()
 * @method MpollDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MpollDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MpollDetail::class);
    }

    // /**
    //  * @return MpollDetail[] Returns an array of MpollDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MpollDetail
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
