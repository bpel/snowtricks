<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $userLogged = $this->getUser();

        $tricks = $this->getDoctrine()->getRepository(Trick::class)->findAllTricks();

        return $this->render('index.html.twig', [
            'tricks' => $tricks,
            'namePage' => 'home',
            'userLogged' => $userLogged
        ]);
    }
}
