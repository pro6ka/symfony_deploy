<?php


namespace App\Manager;


use App\Entity\Mpoll;
use Doctrine\ORM\EntityManagerInterface;

class MpollManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function create(array $data)
    {
        /*$mpoll = new Mpoll();
        $mpoll->setName($data['name'])
            ->setDescription($data['description'])
            ->setMstatus($data['mstatus'])
            ->setPrice($data['price']);*/

    }

}