<?php

namespace App\DataFixtures;

use App\Entity\TypeHoraire;
use App\Entity\Horaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HoraireFixtures  extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
    {
        $generator  = Factory::create("fr_FR");
        $typeHoraire = $manager->getRepository(TypeHoraire::class)->findAll();

        for ($i = 0; $i <= 100; $i++) {
            $horaire = new Horaire();
            $horaire->setNom($generator->name);
            $horaire->setPriorite(rand(0,3));
            $horaire->setTypeHoraire($generator->randomElement($typeHoraire));
			$dateA = $generator->dateTime;
			$dateB = $generator->dateTime;
			if($dateA<$dateB)
			{
				$horaire->setDateHeureDebut($dateA);
				$horaire->setDateHeureFin($dateB);
			}
			else
			{
				$horaire->setDateHeureDebut($dateB);
				$horaire->setDateHeureFin($dateA);
			}
            

            $manager->persist($horaire);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TypeHoraireFixtures::class];
    }
}
