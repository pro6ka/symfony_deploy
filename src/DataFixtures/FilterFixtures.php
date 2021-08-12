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
            $this->addReference(self::getReferenceKey($i), $filter);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FilterTypeFixtures::class
        ];
    }

    public static function getReferenceKey($i) :string
    {
        return sprintf('filter_%s', $i);
    }
}
