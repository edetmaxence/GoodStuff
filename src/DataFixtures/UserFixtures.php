<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) { 
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword(password_hash($faker->password, PASSWORD_ARGON2I));

            $this->addReference("users_$i", $user);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
