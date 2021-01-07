<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $users = [];
        $faker = Factory::create();
        for ($i=0; $i < 10; $i++) { 
            $user = new User();
            $user->setEmail($faker->safeEmail)
                 ->setPassword(password_hash("password", PASSWORD_BCRYPT))
                 ->setRoles(["ROLE_USER"]);
            $users[] = $user;
            $manager->persist($user);
        }

        for ($i=0; $i < 1000; $i++) { 
            $article = new Article();
            $article->setCreatedAt($faker->dateTime($max = 'now', $timezone = null))
                    ->setTitle($faker->text($maxNbChars = 255))
                    ->setContent($faker->text($maxNbChars = 5000))
                    ->setAuthor($faker->randomElement($array = $users));
            $manager->persist($article);
        }
        $manager->flush();
    }
}
