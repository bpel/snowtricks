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
        $videoUrlList = [
            'https://www.youtube.com/watch?v=SQyTWk7OxSI',
            'https://www.youtube.com/watch?v=s3jRiFyOijw',
            'https://www.youtube.com/watch?v=gbHU6J6PRRw',
            'https://www.youtube.com/watch?v=AbzpbQTnUY4',
            'https://www.youtube.com/watch?v=Zc8Gu8FwZkQ',
            'https://www.youtube.com/watch?v=kib-8HbKyPU',
            'https://www.youtube.com/watch?v=2RjS4-T7IdU',
            'https://www.youtube.com/watch?v=4o6vzGE1CUc',
            'https://www.youtube.com/watch?v=de6DOa1C380',
            'https://www.youtube.com/watch?v=V9xuy-rVj9w',
            'https://www.youtube.com/watch?v=_2TkKJ6euDc',
            'https://www.youtube.com/watch?v=nMAvJtpNvJI',
            'https://www.youtube.com/watch?v=cVKamPWu_Sc',
            'https://www.youtube.com/watch?v=GnYAlEt-s00',
            'https://www.youtube.com/watch?v=ShFWBg6Dwws',
            'https://www.youtube.com/watch?v=1CR0QmCaMTs',
            'https://www.youtube.com/watch?v=GNgv_Ean6WM',
            'https://www.youtube.com/watch?v=pMdS_U7eBPM',
            'https://www.youtube.com/watch?v=paykBHgyl1U',
            'https://www.youtube.com/watch?v=UAvMnJwlucM',
            'https://www.youtube.com/watch?v=CRgZa_NWbo8'
        ];


        for ($i = 0; $i<=20;$i++)
        {
            $video = new Video();
            $video->setUrl($videoUrlList[$i]);
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