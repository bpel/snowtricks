<?php

namespace App\DataFixtures;
use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i<=15;$i++)
        {
            for ($j = 1; $j<=3; $j++)
            {
                $message = new Message();
                $message->setMessage("message".$j." Figure n°".$i);
                $message->setDateCreate($faker->dateTimeThisYear('now', null));
                $message->setUser($this->getReference('user' . mt_rand('1', '15')));
                $message->setTrick($this->getReference('trick' . $i));
                $manager->persist($message);
            }
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            TrickFixtures::class,
            UserFixtures::class,
        );
    }

}