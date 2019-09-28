<?php

namespace App\Service;

class Mailer {

    private $mailer;
    private $from = "no-reply@example.fr";
    private $reply = "contact@example.fr";

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMessage($to, $subject, $bodyMessage)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($this->from)
            ->setReplyTo($this->reply)
            ->setTo($to)
            ->setBody($bodyMessage)
            ->setContentType('text/html')
        ;
        $this->mailer->send($message);
        return true;
    }



}