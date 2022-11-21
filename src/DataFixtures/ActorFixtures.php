<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Repository\ProgramRepository;
use DateTime;
use Doctrine\ORM\EntityManager;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $slugs = [
            "Walking-dead", "Men-in-Black", "Alice-aux-pays-de-merveilles",
            "Tintin-et-les-...", "Breakpoint"
        ];
        for ($k = 1; $k < 10; $k++) {
            $actor = new Actor();
            $actor->setFirstname($faker->firstname());
            $actor->setLastname($faker->lastname());
            $actor->setBirthDate(new DateTime($faker->date()));

            for ($i = 1; $i <= 3; $i++) {
                $progId = rand(0, 4);
                $actor->addProgram($this->getReference("program_" . $slugs[$progId]));
            }
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont EpisodeFixtures dépend
        return [
            SeasonFixtures::class,
        ];
    }
}
