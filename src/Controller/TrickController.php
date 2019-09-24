<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\Illustration;
use App\Entity\User;
use App\Form\MessageType;
use App\Form\TrickType;
use App\Service\UploadService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormInterface;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/new", name="trick_create")
     */
    public function create(Request $request, ObjectManager $manager, UploadService $upload)
    {
        $userLogged = $this->getUser();

        if(empty($userLogged)) { return $this->redirectToRoute('error_page_protected'); }

        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $files = $request->files->get('trick','illustration');

            foreach($trick->getVideos() as $video) {
                $manager->persist($video);
            }

            foreach($trick->getIllustrations() as $index => $illustration) {
                $file = $files['illustrations'][$index]['file'];
                $newNameFile = $upload->saveFile($file);
                $illustration->setFilename($newNameFile);
                $manager->persist($illustration);
            }
            $manager->persist($trick);
            $manager->flush();
        }

        return $this->render('trick/addTrick.html.twig', [
            'form' => $form->createView(),
            'namePage' => 'trick_create',
            'userLogged' => $userLogged
        ]);
    }


    /**
     * @Route("/trick/show/{id}", name="trick_show")
     */
    public function show($id, Request $request, ObjectManager $manager)
    {
        $em = $this->getDoctrine()->getManager();

        $trick = $em->getRepository(Trick::class)->findAllOneTrick($id);

        $userLogged = $this->getUser();

        if(empty($userLogged))
        {
            $this->addFlash('info','Connectez-vous pour pouvoir écrire un message.');
            return $this->render('trick/showTrick.html.twig', [
                'trick' => $trick,
                'namePage' => 'trick_show',
            ]);
        }


        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $message->setUser($userLogged);
            $message->setDateCreate(null);
            $manager->persist($message);

            $trick->addMessage($message);
            $manager->persist($trick);
            $manager->flush();

        }

        return $this->render('trick/showTrick.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
            'namePage' => 'trick_show',
            'userLogged' => $userLogged
        ]);
    }

    /**
     * @Route("/trick/edit/{id}", name="trick_edit")
     */
    public function edit($id, Request $request, ObjectManager $manager, UploadService $upload)
    {
        $userLogged = $this->getUser();

        if(empty($userLogged)) { return $this->redirectToRoute('error_page_protected'); }

        $em = $this->getDoctrine()->getManager();

        $trick = $em->getRepository(Trick::class)->findAllOneTrick($id);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('trick','illustration');

            foreach($form->getData()->getVideos() as $video) {
                $manager->persist($video);
            }

            foreach($form->getData()->getIllustrations() as $index => $illustration) {
                $file = $files['illustrations'][$index]['file'];
                if(!empty($file))
                {
                    $newNameFile = $upload->saveFile($file);
                    $illustration->setFilename($newNameFile);
                    $manager->persist($illustration);
                }
            }

            $manager->persist($trick);
            $manager->flush();
            $this->addFlash('success','La figure '.$trick->getNameTrick().' à été modifiée.');
        }

        return $this->render('trick/editTrick.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
            'namePage' => 'trick_edit',
            'userLogged' => $userLogged
        ]);
    }

    /**
     * @Route("/trick/delete/{id}", name="trick_delete")
     */
    public function delete($id, Request $request, ObjectManager $manager)
    {
        $userLogged = $this->getUser();
        if(empty($userLogged)) { return $this->redirectToRoute('error_page_protected'); }

        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository(Trick::class)->findOneBy(['id'=>$id]);

        if (empty($trick) || empty($id))
        {
            $this->addFlash('error','Suppression impossible, cette figure n\'existe pas!');
            return $this->redirectToRoute('home');
        }

        $manager->remove($trick);
        $manager->flush();

        $this->addFlash('success',"La figure ".$trick->getNameTrick()." à été supprimée.");
        return $this->redirectToRoute('home');
    }
}
