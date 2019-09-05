<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Common\Persistence\ObjectManager;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/user/list", name="user_list")
     */
    public function show()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('user/listUsers.html.twig', [
            'users' => $users,
            'namePage' => 'user_list'

        ]);
    }
    /**
     * @Route("/user/register", name="user_register")
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
       $user = new User();

       $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'namePage' => 'user_register'
        ]);
    }
    /**
     * @Route("/user/login", name="user_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        if(!empty($error)) { $error = $error->getMessage(); }

        $emailAdress = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'error' => $error,
            'namePage' => 'user_login',
            'emailAdress' => $emailAdress
        ]);
    }
    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logout()
    {

    }
}
