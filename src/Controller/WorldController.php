<?php


namespace App\Controller;


use App\Manager\FilterManager;
use App\Manager\FilterTypeManager;
use App\Manager\MpollManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function rand;

class WorldController extends AbstractController
{


    private MpollManager $mpollManager;
    private FilterTypeManager $filterTypeManager;
    private FilterManager $filterManager;

    public function __construct(MpollManager $mpollManager, FilterTypeManager $filterTypeManager, FilterManager $filterManager)
    {


        $this->mpollManager = $mpollManager;
        $this->filterTypeManager = $filterTypeManager;
        $this->filterManager = $filterManager;
    }

    /**
     * @Route("/world/hello")
     */
    public function hello(): Response
    {



//        return new Response('<html><body><h1><b>Hello,</b> <i>world</i>!</h1></body></html>');
//        return new Response();

     /* $mpoll = [
          'name' => 'Test' ,
          'description' => 'description' ,
          'mstatus' => rand(1,5) ,
          'name' =>  ,
      ];*/

        $filterData = [
            'name' => 'FilterType' . rand(1, 100),
            'description' => 'Description' . rand(1, 100),
            'id' => rand(1, 100),

        ];

//        $filterType = $this->mpollManager->create($filterData);
        $filterType= $this->filterTypeManager->create($filterData);
        return $this->json($filterType->toArray());
    }

    /**
     * @Route("/world/filter")
     */
    public function filter(): Response
    {
        $data = [
            'name' => 'Filter' . rand(1, 100),
            'description' => 'Description' . rand(1, 100),
            'value' => rand(100, 1000),
        ];

        $filter = $this->filterManager->create($data);
        return $this->json($filter->toArray());
    }




}