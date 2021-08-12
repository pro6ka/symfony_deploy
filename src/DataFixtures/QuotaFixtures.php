<?php

namespace App\DataFixtures;

use App\Entity\Quota;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class QuotaFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var Generator */
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        for($i=0; $i < 5; $i++){


            $filter_index = $this->faker->numberBetween(0, 18);

        // Create two Filters for one Quota
        $filter = $this->getReference(FilterFixtures::getReferenceKey( $filter_index));
        $filter1 = $this->getReference(FilterFixtures::getReferenceKey( $filter_index + 1));

            $quota = new  Quota();
            $quota
                ->setName('Quota' . rand(1, 5))
                ->setDescription('Description' . rand(1, 100))
//                ->setCreatedAt(new \DateTime())
//                ->setUpdatedAt(new \DateTime())
            ->addFilter($filter)
            ->addFilter($filter1)
            ;
            $manager->persist($quota);
            $this->addReference(self::getReferenceKey($i), $quota);
        }

        $manager->flush();
    }

    public static function getReferenceKey($i) :string
    {
        return sprintf('quota_%s', $i);
    }

    public function getDependencies()
    {
       return [
           FilterFixtures::class
       ];
    }


}
