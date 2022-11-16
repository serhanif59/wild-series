<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        "T-shirt Homme",
        "T-shirt Femme",
        "T-shirt Enfant",
        "Chemise Homme",
        "Chemise Femme",
        "Chemise Enfant",
        "Pantalon Homme",
        "Pantalon Femme",
        "Pantalon Enfant"
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $value) {
            $category = new Category();
            $category->setName($value);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
