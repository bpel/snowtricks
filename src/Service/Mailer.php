<?php

namespace App\Service;

use Swift_Attachment;
use Twig\Environment;

class Mailer {

    private $mailer;
    private $from = "no-reply@example.fr";
    private $reply = "contact@example.fr";
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function getDate()
    {
        try {
            return new \DateTime('now');
        } catch (\Exception $e) {
            return false;
        }
    }

    public function sendMessage($to, $subject, $viewName, $datas = null)
    {
        if(empty($viewName)) { $viewName = "mail"; }

        $message = (new \Swift_Message($subject))
            ->setFrom($this->from)
            ->setReplyTo($this->reply)
            ->setTo($to)
            ->setBody(
                $this->twig->render('mail/'.$viewName.'.html.twig', [
                    'dateNow' => $this->getDate(),
                    'datas' => $datas
                ])
            )
            ->setContentType('text/html')
        ;
        $this->mailer->send($message);
    }



}