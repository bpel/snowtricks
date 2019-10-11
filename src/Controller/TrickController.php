<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Trick;
use App\Form\MessageType;
use App\Form\TrickType;
use App\Service\UploadService;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/new", name="trick_create")
     */
    public function create(Request $request, ObjectManager $manager, UploadService $upload)
    {
        $userLogged = $this->getUser();

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
            $this->addFlash('success','La figure '.$trick->getNameTrick().' à été créé.');
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
    public function show($id, Request $request, ObjectManager $manager, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $trick = $em->getRepository(Trick::class)->findAllOneTrick($id);

        if(!empty($this->getUser()))
        {
            $message = new Message();
            $form = $this->createForm(MessageType::class, $message);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $message->setUser($this->getUser());
                $message->setTrick($trick);
                $manager->persist($message);
                $manager->flush();
                $this->addFlash('success','Votre message à bien été ajouté!');
            }

            $messages = $paginator->paginate($em->getRepository(Message::class)->findAllMessagesOneTrick($id),
                $request->query->getInt('page', 1), 5);

            if(empty($trick)) { $this->addFlash('error',"Cette figure n'existe pas"); }

            return $this->render('trick/showTrick.html.twig', [
                'trick' => $trick,
                'messages' => $messages,
                'form' => $form->createView()
            ]);

        }

        $messages = $paginator->paginate($em->getRepository(Message::class)->findAllMessagesOneTrick($id),
            $request->query->getInt('page', 1), 5);

        return $this->render('trick/showTrick.html.twig', [
            'trick' => $trick,
            'messages' => $messages
        ]);
    }

    /**
     * @Route("/trick/edit/{id}", name="trick_edit")
     */
    public function edit($id, Request $request, ObjectManager $manager, UploadService $upload)
    {
        $userLogged = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $trick = $em->getRepository(Trick::class)->findAllOneTrick($id);

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('trick','illustration');
            foreach($form->getData()->getIllustrations() as $index => $illustration) {
                $file = $files['illustrations'][$index]['file'];
                if (!empty($file)) {
                    $newNameFile = $upload->saveFile($file);
                    $illustration->setFilename($newNameFile);
                    $manager->persist($illustration);
                }
            }
            foreach($trick->getVideos() as $video)
            {
                $manager->persist($video);
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
