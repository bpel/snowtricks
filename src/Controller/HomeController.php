<?php

namespace App\Controller;

use App\Entity\Trick;
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
            $this->addFlash('info','Aucune figure à afficher.');
        }

        return $this->render('index.html.twig', [
            'tricks' => $tricks,
            'namePage' => 'home',
            'userLogged' => $userLogged
        ]);
    }
}
