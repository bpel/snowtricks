<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i<=15;$i++)
        {
            $user = new User;
            $user->setLastnameUser($faker->lastName);
            $user->setNameUser($faker->name);
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user,$faker->password));
            $user->setIllustration($this->getReference('illustrationUser'.$i));

            $manager->persist($user);
            $this->addReference('user'.$i, $user);
        }

            $userDemo = new User();
            $userDemo->setNameUser("Demo");
            $userDemo->setLastnameUser("Test");
            $userDemo->setEmail("demo@test.fr");;
            $userDemo->setPassword($this->encoder->encodePassword($userDemo,"demo"));
            $manager->persist($userDemo);

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            IllustrationFixtures::class,
        );
    }

}