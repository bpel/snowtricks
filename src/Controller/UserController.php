<?php

namespace App\Controller;

use App\Entity\Illustration;
use App\Entity\User;
use App\Form\EditIllustrationType;
use App\Form\EditPasswordType;
use App\Form\PasswordLostType;
use App\Form\PasswordRecoveryType;
use App\Form\RegisterType;
use App\Service\PasswordLostService;
use App\Service\PasswordRecoveryService;
use App\Service\UploadService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
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
    public function login(AuthenticationUtils $authenticationUtils)
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
     * @Route("/user/password/edit", name="user_password_edit")
     */
    public function editPassword(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        if ($this->userLogged())
        {
            $idUser = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['id' => $idUser]);

            $formEditPassword = $this->createForm(EditPasswordType::class, $user);

            $formEditPassword->handleRequest($request);
            if($formEditPassword->isSubmitted() && $formEditPassword->isValid()) {
                $user->setPassword($encoder->encodePassword($user,$user->getPassword()));
                $manager->persist($user);
                $manager->flush();
            }

            return $this->render('user/editPassword.html.twig', [
                'namePage' => 'user_password_edit',
                'formEditPassword' => $formEditPassword->createView(),
                'errors' => $formEditPassword->getErrors()
            ]);
        }

        return $this->redirectToRoute('error_page_protected');
    }

    /**
     * @Route("/user/illustration/edit", name="user_illustration_edit")
     */
    public function editIllustration(Request $request, ObjectManager $manager, UploadService $upload)
    {
        if ($this->userLogged())
        {
            $idUser = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['id' => $idUser]);

            $formEditIllustration = $this->createForm(EditIllustrationType::class, $user);

            $formEditIllustration->handleRequest($request);
            if ($formEditIllustration->isSubmitted() && $formEditIllustration->isValid()) {
                $file = $formEditIllustration->get('illustration')->getData();
                $nameFileUploded = $upload->saveFile($file);

                $illustrationUser = new Illustration();
                $illustrationUser->setFilename($nameFileUploded);

                $user->setIllustration($illustrationUser);
                $manager->persist($user);
                $manager->flush();
            }

            return $this->render('user/editIllustration.html.twig', [
                'namePage' => 'user_illustration_edit',
                'user' => $this->getUser(),
                'formEditIllustration' => $formEditIllustration->createView()
            ]);
        }

        return $this->redirectToRoute('error_page_protected');
    }

    /**
     * @Route("/user/profile", name="user_profile")
     */
    public function profile()
    {
        if ($this->userLogged()) {
            return $this->render('user/profile.html.twig', [
                'namePage' => 'user_profile',
            ]);
        }
        return $this->redirectToRoute('error_page_protected');
    }

    /**
     * @Route("/user/password/lost", name="user_password_lost")
     */
    public function passwordLost(Request $request, PasswordLostService $passwordService, $message = ""){
        $formPasswordLost = $this->createForm(PasswordLostType::class);

        $formPasswordLost->handleRequest($request);
        if ($formPasswordLost->isSubmitted() && $formPasswordLost->isValid()) {
            $datas = $formPasswordLost->getData();

            $passwordService->passwordLost($datas->getEmail());

            $error = $passwordService->getErrorTokenLost($datas->getEmail());

            if($error)
            {
                $this->addFlash('error',$error);
            }

            if($error == false)
            {
                $this->addFlash('success',"Email avec lien de réinitialisation envoyé!");
            }
        }

        return $this->render('user/passwordLost.html.twig', [
            'namePage' => 'user_password_lost',
            'user' => $this->getUser(),
            'formPasswordLost' => $formPasswordLost->createView(),
        ]);
    }

    /**
     * @Route("/user/password/recovery", name="user_password_recovery")
     */
    public function passwordRecoveryToken(Request $request, PasswordRecoveryService $passwordRecovery, $message = ""){

        if (!$passwordRecovery->tokenIsValid($request->query->get('token')))
        {
            $error = $passwordRecovery->getErrorTokenRecovery($request->query->get('token'));
            $this->addFlash('error',$error);

            return $this->render('user/passwordRecovery.html.twig', [
                'namePage' => 'user_password_recovery_token',
                'user' => $this->getUser()
            ]);
        }

        $formPasswordChange = $this->createForm(EditPasswordType::class);

        $formPasswordChange->handleRequest($request);

        if ($formPasswordChange->isSubmitted() && $formPasswordChange->isValid()) {
            $token = $request->query->get('token');
            $datas = $formPasswordChange->getData();
            $passwordRecovery->passwordRecovery($datas->getPassword(), $token);

            $this->addFlash('success','Le mot de passe à bien été modifié.');
            return $this->redirectToRoute("user_login");
        }

        return $this->render('user/passwordRecovery.html.twig', [
            'namePage' => 'user_password_recovery_token',
            'user' => $this->getUser(),
            'formPasswordChange' => $formPasswordChange->createView(),
            'message' => $message
        ]);
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logout(){}

    public function userLogged()
    {
        if(empty($this->getUser())) {
           return false;
        }
        return true;
    }
}
