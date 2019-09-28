<?php
namespace App\Tests\Entity;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function testNameUser()
    {

    }

    public function testCreateSameTrick()
    {
        #$userRepository = $this->objectManager->getRepository(User::class);

    }
}