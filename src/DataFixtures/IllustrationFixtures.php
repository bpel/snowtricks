<?php

namespace App\DataFixtures;
use App\Entity\Illustration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class IllustrationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i<=40;$i++)
        {
            $illustration = new Illustration();
            $illustration->setUrl($faker->url);

            $manager->persist($illustration);
            $this->addReference('illustration'.$i, $illustration);
        }

        $manager->flush();

    }

}