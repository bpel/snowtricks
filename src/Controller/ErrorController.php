<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error/page/protected", name="error_page_protected")
     */
    public function UnloggedUser()
    {
        return $this->render('error/pageProtected.html.twig', [
        ]);
    }
}
