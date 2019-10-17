<?php
namespace tests\Framework;

use App\Entity\Illustration;
use App\Entity\Trick;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestAbstract extends WebTestCase
{
    private $em;
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();

        $container = static::$container;

        $this->em = $container->get('doctrine')->getManager();

        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();

        $schemaTool = new SchemaTool($this->em);

        $schemaTool->dropDatabase();

        $schemaTool->createSchema($metadatas);
    }

    /** @test
     *  Create x tricks and check if they are displayed on index
     */
    public function testTrickCreate()
    {
        for ($i = 0; $i < 3; $i++) {
            $trick = new Trick();
            $trick->setNametrick("trick" . $i);
            $trick->setDescription("description trick".$i);
            $this->em->persist($trick);
            $this->em->flush();
        }

        $this->client->request('GET', '/');

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        for ($j =0; $j < $i; $j++)
        {
            $this->assertContains("trick".$j, $responseContent);
        }
    }

    /** @test
     * Create 1 trick, remove the trick and seed if illustrations of this trick exist
     */
    public function testDeleteTrick()
    {
        // creation
        $illustration = new Illustration();
        $illustration->setFilename("ski.png");

        $this->em->persist($illustration);

        $trick = new Trick();
        $trick->setNametrick("Trick illustration");
        $trick->setDescription("desc");
        $trick->setIllustrations([$illustration]);

        $this->em->persist($trick);

        $this->em->flush();

        // check exist BDD
        $trickBDD = $this->em->getRepository(Trick::class)->findOneBy(['nametrick' => $trick->getNametrick()]);

        $illustrationsBDD = $trickBDD->getIllustrations();

        $this->assertEquals('ski.png',$illustrationsBDD[0]->getFilename());

        // deletion
        $this->em->remove($trick);
        $this->em->flush();

        // check if delete on cascade worked
        $illustration = $this->em->getRepository(Illustration::class)->findOneBy(['filename' => 'ski.png']);

        $this->assertNull($illustration);
    }

    /** @test
     * Create 1 trick, edit them and check if edit worked
     */
    public function testEditTrick()
    {
        // create trick
        $trick = new Trick();
        $trick->setNametrick("Trick initial");
        $trick->setDescription("desc");

        $this->em->persist($trick);

        $this->em->flush();

        // check trick exist
        $this->client->request('GET', '/');
        $response = $this->client->getResponse();
        $responseContent = $response->getContent();
        $this->assertContains($trick->getNametrick(), $responseContent);

        // edit trick
        $trick->setNametrick("Trick edited");

        $this->em->persist($trick);

        $this->em->flush();

        // check trick exist and name updated
        $this->client->request('GET', '/');
        $response = $this->client->getResponse();
        $responseContent = $response->getContent();
        $this->assertContains($trick->getNametrick(), $responseContent);
    }

    /** @test
     * Create 2 tricks with the same name and check if exception
     */
    public function testCreateTrickSameName()
    {
        try {
            // create first trick
            $trick1 = new Trick();
            $trick1->setNametrick("Trick initial");
            $trick1->setDescription("desc");

            $this->em->persist($trick1);

            $this->em->flush();

            // create second trick
            $trick2 = new Trick();
            $trick2->setNametrick("Trick initial");
            $trick2->setDescription("desc");

            $this->em->persist($trick2);

            $this->em->flush();
        } catch (\Exception $e) {
            $this->assertNotNull($e);
        }
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
