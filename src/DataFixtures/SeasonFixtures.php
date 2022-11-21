<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASONS = [
        ['number' => '1', 'year' => '2012', 'description' => 'Saison 1', 'program' =>'program_Walking-dead'],
        ['number' => '2', 'year' => '2014', 'description' => 'Saison 2', 'program' =>'program_Walking-dead'],
        ['number' => '3', 'year' => '2016', 'description' => 'Saison 3', 'program' =>'program_Walking-dead'],
        ['number' => '4', 'year' => '2018', 'description' => 'Saison 4', 'program' =>'program_Walking-dead'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $seas) {
            $season = new Season();
            $season->setNumber($seas['number']);
            $season->setYear($seas['year']);
            $season->setDescription($seas['description']);
            $season->setProgram($this->getReference($seas['program']));
            $manager->persist($season);
            $this->addReference('season_' . $seas['number'], $season);
        }
        $manager->flush();
    }
    
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont SeasonFixtures dépend
        return [
          ProgramFixtures::class,
        ];
    }
}
