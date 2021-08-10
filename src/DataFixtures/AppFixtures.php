<?php

namespace App\DataFixtures;

use App\Factory\FilterTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        FilterTypeFactory::new()->createOne(['id' => 1]);


        $manager->flush();
    }
}
