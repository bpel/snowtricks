<?php

namespace App\Service;

use App\Entity\TokenPasswordLost;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PasswordService {
    private $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
    }

    public function passwordLost($email, $message = "")
    {
        if(!$this->checkUserExistDatabase($email)) { return $message = "Ce compte n'existe pas!"; }

        $user = $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($this->getTokenDatabase($user)) { return $message = "Erreur : une demande est toujours en cours!"; };

        if (!$this->generateToken()) { return $message = "Erreur génération token, contacter l'adminitrateur!"; }

        if ($this->saveTokenDatabase($this->generateToken(),$user)) { $message = "Un email vient de vous être envoyé pour réinitialiser votre mot de passe!"; }

        return $message;
    }

    public function checkUserExistDatabase($email)
    {
        if (!empty($this->manager->getRepository(User::class)->findBy(['email' => $email])))
        {
            return true;
        }
        return false;
    }

    public function generateToken()
    {
        try {
            $token = bin2hex(random_bytes(64));
        } catch (\Exception $e) {
            return false;
        }
        return $token;
    }

    public function saveTokenDatabase($token, $user)
    {
        $tokenPasswordLost = new TokenPasswordLost();
        $tokenPasswordLost->setToken($token);
        $tokenPasswordLost->setUser($user);
        $tokenPasswordLost->setExpirationDate($this->getDateExpiration());
        $this->manager->persist($tokenPasswordLost);
        $this->manager->flush();
        return true;
    }

    public function getTokenDatabase($user)
    {
        $tokens = $this->manager->getRepository(TokenPasswordLost::class)->findAllTokenAvailable($user,$this->getDateNow());

        if(empty($tokens)) { return false; }
        return true;
    }

    public function getDateNow()
    {
        try {
            return new \DateTime('now');
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getDateExpiration()
    {
        return $this->getDateNow()->modify('+30 minutes');
    }

}