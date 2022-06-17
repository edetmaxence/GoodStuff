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
            $user->setFirstname($faker->name);
            $user->setLastname($faker->name);
            $user->setPseudonyme($faker->lastName);
            $user->setPostcode(rand(1, 99999));
            $user->setCity($faker->city);
            $user->setPhone(rand(60000000, 79999999));

            $this->addReference("users_$i", $user);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
