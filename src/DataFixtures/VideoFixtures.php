<?php

namespace App\DataFixtures;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i<=20;$i++)
        {
            $video = new Video();
            $video->setUrl("url video".$i);
            $video->setPlatformVideo($this->getReference('platformvideo'.mt_rand('0', '6')));

            $manager->persist($video);
            $this->addReference('video'.$i, $video);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            PlatformVideoFixtures::class,
        );
    }

}