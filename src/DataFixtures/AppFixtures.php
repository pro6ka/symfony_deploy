<?php

namespace App\DataFixtures;

use App\Factory\FilterFactory;
use App\Factory\FilterTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

      /*$filterType =  FilterTypeFactory::new()->createOne(['id' => 1]); // !!!!*/


//        FilterTypeFactory::new()->createMany(5);

       /* FilterFactory::new()->createMany(5, function (){
           return ['filterType' => FilterTypeFactory::random()];
        });*/

       /* FilterFactory::createMany(5, function (){
            return ['filterType' => FilterTypeFactory::random()];
        });*/



        /*FilterFactory::createOne(['filterType' => $filterType]);
//        FilterFactory::createOne(['filterType' => $filterType]);
        $filter = FilterFactory::createOne();
        $filter->setFilterType($filterType);
        $manager->flush();*/
    }
}
