<?php


namespace App\Controller;


use App\Entity\FilterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WorldController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /*
     * @Route()
     */
    public function hello(): Response
    {
        return new Response('<html><body><h1><b>Hello,</b> <i>world</i>!</h1></body></html>');
//        return new Response();

      /*  $filterType = new FilterType();
        $filterType->setName('TEST');
        $filterType->setDescription('DESCRIPTION');

        $this->entityManager->persist($filterType);
        $this->entityManager->flush();*/

    }




}