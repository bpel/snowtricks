<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i<=15;$i++)
        {
            $user = new User;
            $user->setLastnameUser($faker->lastName);
            $user->setNameUser($faker->name);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setIllustration($this->getReference('illustrationUser'.$i));

            $manager->persist($user);
            $this->addReference('user'.$i, $user);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            IllustrationFixtures::class,
        );
    }

}