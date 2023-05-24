<?php

namespace App\DataFixtures;

use App\Entity\TypeHoraire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeHoraireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		
		$generator = Factory::create("fr_FR");
		
		for($i = 0; $i< 20; $i++)
		{
			$typeHoraire = new TypeHoraire();
			$typeHoraire->setNom($generator->name);
			$manager->persist($typeHoraire);
		}
        $manager->flush();
    }
}