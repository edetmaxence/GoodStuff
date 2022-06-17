<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Doctrine\Persistence\ObjectManager;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) { 
            $article = new Article;
            $article->setTitle($faker->name);
            $article->setDescription($faker->words(50, true));
            $article->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-10 years')));
            $article->setCategory($this->getReference("category_". rand(1, 14)));
            $article->setOwner($this->getReference("users_". rand(1, 50)));
            

            $manager->persist($article);
        }

        $manager->flush();
    }
}
