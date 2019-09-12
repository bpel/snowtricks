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

        for ($i = 1; $i<=60;$i++)
        {
            $message = new Message();
            $message->setMessage("message".$i);
            $message->setDateCreate($faker->dateTimeThisYear('now', null));
            $message->setUser($this->getReference('user' . mt_rand('1', '15')));
            $manager->persist($message);
            $this->addReference('message'.$i, $message);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }

}