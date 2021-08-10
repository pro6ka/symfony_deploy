<?php


namespace App\Manager;


use App\Entity\Filter;
use Doctrine\ORM\EntityManagerInterface;

class FilterManager
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function create(array $data)
    {
        $filter = new Filter();
        $filter->setName($data['name'])
        ->setDescription($data['description'])
        ->setValue($data['value']);

        $this->entityManager->persist($filter);
        $this->entityManager->flush();

        return $filter;
    }

}