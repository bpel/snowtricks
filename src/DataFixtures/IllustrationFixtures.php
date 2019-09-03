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
            $illustration->setFilename($faker->numberBetween(1,15).'.jpg');

            $manager->persist($illustration);
            $this->addReference('illustration'.$i, $illustration);
        }

        for ($j =1; $j <= 15; $j++) {
            $illustrationUser = new Illustration();
            $illustrationUser->setFilename("user".$j.".jpg");
            $manager->persist($illustrationUser);
            $this->addReference('illustrationUser'.$j, $illustrationUser);
        }

        $manager->flush();

    }

}