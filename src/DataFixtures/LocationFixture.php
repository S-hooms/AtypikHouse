<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LocationFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++)
        {
            $location = new Location();
            $location
                ->setTitre($faker->words(3, true))
                ->setDescription($faker->sentence(3, true))
                ->setSurface($faker->numberBetween(20, 350))
                ->setPieces($faker->numberBetween(2,10))
                ->setChambres($faker->numberBetween(1, 9))
                ->setEtage($faker->numberBetween(0, 15))
                ->setPrix($faker->numberBetween(100000, 1000000))
                ->setChauffage($faker->numberBetween(0, count(Location::Chauffage) - 1))
                ->setVille($faker->city)
                ->setAddresse($faker->address)
                ->setCodePostal($faker->postcode)
                ->setLouer(false);   
                $manager->persist($location);     
        }

        $manager->flush();
    }
}
