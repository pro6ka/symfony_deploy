<?php

namespace App\DataFixtures;

use App\Entity\Mpoll;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class MpollFixtures extends Fixture
{

    /** @var Generator */
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for($i=0; $i < 5; $i++){

            $mpoll = new Mpoll();
            $mpoll
                ->setName('Mpoll_' . $i)
                ->setDescription($this->faker->text(30))
                ->setPrice($this->faker->numberBetween(1,20))
                ->setMstatus($this->faker->numberBetween(0,4))
                ->setLink($this->faker->url().'&sub_id=[SUB]')
                ;
            $manager->persist($mpoll);
            $this->addReference(self::getReferenceKey($i), $mpoll);
        }


        $manager->flush();
    }

    public static function getReferenceKey($i) :string
    {
        return sprintf('mpoll_%s', $i);
    }

}
