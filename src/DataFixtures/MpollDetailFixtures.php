<?php

namespace App\DataFixtures;

use App\Entity\MpollDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class MpollDetailFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var Generator */
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $mpoll = $this->getReference(MpollFixtures::getReferenceKey($this->faker->numberBetween(0, 4)));
            $quota = $this->getReference(QuotaFixtures::getReferenceKey($this->faker->numberBetween(0, 4)));
        $mpollDetail = new MpollDetail();
            $mpollDetail
                ->setCompletes($this->faker->numberBetween(100, 500))
                ->setMpolls($mpoll)
                ->setQuotas($quota)
;
            $manager->persist($mpollDetail);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MpollFixtures::class,
            QuotaFixtures::class
        ];
    }


}
