<?php

namespace App\DataFixtures;
use App\Entity\TypeTrick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeTrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $listTypeTrick = ['grabs', 'rotations', 'flips','pipe','slide'];

        for ($i = 0; $i<sizeof($listTypeTrick);$i++)
        {
            $typeTrick = new TypeTrick();
            $typeTrick->setDescription("description typetrick".$i);
            $typeTrick->setNameTypetrick($listTypeTrick[$i]);
            $manager->persist($typeTrick);
            $this->addReference('typetrick'.$i, $typeTrick);
        }

        $manager->flush();

    }
}