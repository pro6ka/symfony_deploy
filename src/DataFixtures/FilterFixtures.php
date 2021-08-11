<?php

namespace App\DataFixtures;

use App\Entity\Filter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FilterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 0; $i < 20; $i++){
            $filterType = $this->getReference(FilterTypeFixtures::getReferenceKey($i % 3));

        $filter = new Filter();
        $filter
            ->setName('Filter' . rand(1, 100))
            ->setDescription('Description' . rand(1, 100))
            ->setValue(rand(100, 1000))
            ->setFilterType($filterType)
            ;

            $manager->persist($filter);
        }

        $manager->flush();
       /* $data = [
            'name' => 'Filter' . rand(1, 100),
            'description' => 'Description' . rand(1, 100),
            'value' => rand(100, 1000),
            'filterType' => 1
        ];*/
    }

    public function getDependencies()
    {
        return [
            FilterTypeFixtures::class
        ];
    }
}
