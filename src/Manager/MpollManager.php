<?php


namespace App\Manager;


use Doctrine\ORM\EntityManager;

class MpollManager
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {

        $this->entityManager = $entityManager;
    }


}