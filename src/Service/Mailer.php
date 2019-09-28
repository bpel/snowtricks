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

    public function sendMessage($to, $subject, $bodyMessage)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($this->from)
            ->setReplyTo($this->reply)
            ->setTo($to)
            ->setBody(
                $this->twig->render('mail/mail.html.twig', [
                    'dateNow' => $this->getDate()
                ])
            )
            ->setContentType('text/html')
        ;
        $this->mailer->send($message);
    }



}