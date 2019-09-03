<?php

namespace App\DataFixtures;
use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i<20;$i++)
        {
            $trick = new Trick();
            $trick->setTypeTrick($this->getReference('typetrick'.mt_rand('0','4')));
            $trick->setDescription("description trick".$i);
            $trick->setNameTrick("trick".$i);

            for ($j = 0; $j<mt_rand('0','3');$j++)
            {
                $trick->addVideo($this->getReference('video'.mt_rand('0','20')));
            }

            for ($k = 0; $k<mt_rand('0','3');$k++)
            {
                $trick->addIllustration($this->getReference('illustration'.mt_rand('1','40')));
            }

            for ($l = 0; $l<mt_rand('0','3');$l++)
            {
                $trick->addMessage($this->getReference('message'.mt_rand('1','40')));
            }

            $manager->persist($trick);
            $this->addReference('trick'.$i, $trick);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TypeTrickFixtures::class,
            IllustrationFixtures::class,
            UserFixtures::class,
            VideoFixtures::class,
            MessageFixtures::class,
        );
    }


}