<?php

namespace App\DataFixtures;

use App\Entity\Illustration;
use App\Entity\IllustrationTrick;
use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\TypeTrick;
use App\Entity\User;
use App\Entity\Video;
use App\Entity\VideoTrick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // creation between 5 and 6 TypeTrick
        for ($j = 1; $j <= mt_rand(3,6); $j++) {
            $typeTrick = new TypeTrick();
            $typeTrick->setNameTypetrick('TypeTrick' . $j);
            $manager->persist($typeTrick);

            // creation between 2 and 5 Trick
            for ($k = 1; $k <= mt_rand(2,5); $k++) {
                $trick = new Trick();
                $trick->setNameTrick('Figure '. $faker->city)
                      ->setIdIllustration(null)
                      ->setUrl(null)
                      ->setTypeTrick($typeTrick)
                      ->setDescription("Description figure");
                $manager->persist($trick);

                // creation between 2 and 5 User
                for ($h = 1; $h <= mt_rand(2,5); $h++) {
                    $user = new User();
                    $user->setNameUser($faker->name)
                         ->setEmail($faker->email)
                         ->setLastnameUser($faker->lastName)
                         ->setPassword($faker->password)
                         ->setIdIllustration(null);
                    $manager->persist($user);
                    // create message about trick
                    for ($m = 1; $m <= mt_rand(0,2); $m++) {
                        $message = new Message();
                        $message->setIdTrick($trick)
                                ->setDateCreate($faker->dateTimeBetween('-1 month', '-1 hour'))
                                ->setMessage($faker->realText(mt_rand(10,30)))
                                ->setIdUser($user);
                        $manager->persist($message);
                    }
                }

                // creation between 0 and 2 Illustration
                for ($l = 1; $l <= mt_rand(0,2); $l++) {
                    $illustration = new Illustration();
                    $illustration->setLinkIllustration($faker->imageUrl());
                    $manager->persist($illustration);

                    $illustrationTrick = new IllustrationTrick();
                    $illustrationTrick->setIllustration($illustration);
                    $illustrationTrick->setTrick($trick);
                    $manager->persist($illustrationTrick);
                }

                // creation between 0 and 1 Video
                for ($n = 1; $n <= mt_rand(0,1); $n++) {
                    $video = new Video();
                    $video->setUrl('youtube.com/watch?v='.substr(sha1(rand()),0,11));
                    $manager->persist($video);

                    $videoTrick = new VideoTrick();
                    $videoTrick->setTrick($trick);
                    $videoTrick->setVideo($video);
                    $manager->persist($videoTrick);
                }

            }
        }
        $manager->flush();


    }

}