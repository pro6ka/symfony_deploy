<?php


namespace App\Manager;


use App\Entity\FilterType;
use Doctrine\ORM\EntityManagerInterface;
use function dump;

class FilterTypeManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function create(array $data): FilterType
    {
        $filterType = new  FilterType();

        $filterType->setName($data['name'])
            ->setDescription($data['description'])
            ->setId($data['id']);


        $this->entityManager->persist($filterType);
        $this->entityManager->flush();

        return $filterType;

    }

}