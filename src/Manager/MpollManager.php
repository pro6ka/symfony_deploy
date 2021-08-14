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
        $mpoll = new Mpoll();
        $mpoll
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setMstatus($data['mstatus'])
            ->setPrice($data['price'])
        ;

        $this->entityManager->persist($mpoll);
        $this->entityManager->flush();
    }


    public function findMpollById(int $id) : ?Mpoll
    {
        return
            $this->entityManager->getRepository(Mpoll::class)
                ->findByIdWithQuotas($id);
    }

    public function findByStatus(int $status_id)
    {
        return
            $this->entityManager->getRepository(Mpoll::class)
                ->findByStaus($status_id);
    }

}