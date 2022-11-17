<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        ['year' => 2000 ,'title' => 'Walking dead', 'synopsys' => 'Des zombies envahissent la terre', 'category' => 'category_Action'],
        ['year' => 2000 ,'title' => 'Men in Black', 'synopsys' => 'Des gigolos en noir', 'category' => 'category_Horreur'],
        ['year' => 2000 ,'title' => 'Alice aux pays de merveilles', 'synopsys' => 'Version fantastique d"Alice aux ...', 'category' => 'category_Fantastique'],
        ['year' => 2000 ,'title' => 'Tintin et les ...', 'synopsys' => 'Tintin chez les romains....', 'category' => 'category_Animation'],
        ['year' => 2000 ,'title' => 'Breakpoint', 'synopsys' => 'Braqueurs masqués ....', 'category' => 'category_Action']
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $prog){
            $program = new Program();
            $program->setTitle($prog['title']);
            $program->setSlug(urlencode(str_replace(" ","-",$prog['title'])));
            $program->setSynopsys($prog['synopsys']);
            $program->setCategory($this->getReference($prog['category']));
            $this->addReference('program_' . $program->getSlug(), $program);
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CategoryFixtures::class,
        ];
    }


}
