<?php

namespace App\Repository;

use App\Entity\Mpoll;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mpoll|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mpoll|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mpoll[]    findAll()
 * @method Mpoll[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MpollRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mpoll::class);
    }

    // /**
    //  * @return Mpoll[] Returns an array of Mpoll objects
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
    public function findOneBySomeField($value): ?Mpoll
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
