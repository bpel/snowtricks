<?php

namespace App\DataFixtures;
use App\Entity\PlatformVideo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlatformVideoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $listPlatform = ['Youtube', 'Dalymotion', 'Netflix','VideoPlus','Free','Yahoo','Other'];

        for ($i = 0; $i<sizeof($listPlatform);$i++)
        {
            $platformVideo = new PlatformVideo();
            $platformVideo->setNamePlatform($listPlatform[$i]);

            $manager->persist($platformVideo);
            $this->addReference('platformvideo'.$i, $platformVideo);
        }

        $manager->flush();

    }

}