<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($k = 1; $k < 4; $k++) {
            for ($i = 1; $i <= 10; $i++) {
                $episode = new Episode();
                $episode->setNumber($i);
                $episode->setTitle($faker->word());
                $episode->setSynopsys($faker->paragraphs(3, true));
                $episode->setSeason($this->getReference("season_" . $k));
                $manager->persist($episode);
            }
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
