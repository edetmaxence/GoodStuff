<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 15; $i++) { 
            $category = new Category();
            $category->setName($faker->name);

            $this->addReference("category_$i", $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
