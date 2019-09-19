<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickDeleteType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, $message = "")
    {
        $userLogged = $this->getUser();

        $tricks = $this->getDoctrine()->getRepository(Trick::class)->findAllTricks();

        if (empty($tricks))
        {
            $message = "Aucune figure à afficher!";
        }

        return $this->render('index.html.twig', [
            'tricks' => $tricks,
            'namePage' => 'home',
            'userLogged' => $userLogged,
            'message' => $message
        ]);
    }
}
