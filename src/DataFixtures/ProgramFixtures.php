<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        ['title' => 'Walking dead', 'synopsys' => 'Des zombies envahissent la terre', 'category' => 'category_Action'],
        ['title' => 'Men in Black', 'synopsys' => 'Des gigolos en noir', 'category' => 'category_Horreur'],
        ['title' => 'Alice aux pays de merveilles', 'synopsys' => 'Version fantastique d"Alice aux ...', 'category' => 'category_Fantastique'],
        ['title' => 'Tintin et les ...', 'synopsys' => 'Tintin chez les romains....', 'category' => 'category_Animation'],
        ['title' => 'Breakpoint', 'synopsys' => 'Braqueurs masqués ....', 'category' => 'category_Action']
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $prog){
            $program = new Program();
            foreach ($prog as $key => $value){
                switch ($key){
                    case 'title':
                        $program->setTitle($value);
                        break;
                    case 'synopsys':
                        $program->setSynopsys($value);
                        break;    
                    case 'category':
                        $program->setCategory($this->getReference($value));
                        break;   
                }
            }
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
