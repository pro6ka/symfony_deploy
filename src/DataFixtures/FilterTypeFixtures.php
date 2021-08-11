<?php

namespace App\DataFixtures;

use App\Entity\FilterType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function sprintf;

class FilterTypeFixtures extends Fixture
{
    public static function getReferenceKey($i) :string
    {
        return sprintf('filterType_%s', $i);
    }
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i=0; $i < 5; $i++){
            $filterType = new  FilterType();
            $filterType
                ->setId($i)
                ->setName('FilterType' . rand(1, 100))
                ->setDescription('Description' . rand(1, 100))
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ;
            $manager->persist($filterType);
            $this->addReference(self::getReferenceKey($i), $filterType);
        }


        $manager->flush();
    }
}
