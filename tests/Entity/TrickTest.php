<?php
namespace App\Tests\Entity;

use App\Entity\Trick;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;

class TrickTest extends TestCase
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function testNameTrick()
    {
        $trick = new Trick();
        $name = "trick1";

        $trick->setNameTrick($name);
        $this->assertEquals("trick1", $trick->getNameTrick());
    }

    public function testGetTrick($id)
    {
        $trickRepository = $this->objectManager->getRepository(Trick::class);
        $trick = $trickRepository->find($id);
        return $trick;
    }
}