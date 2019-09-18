<?php

namespace App\Service;

use App\Entity\TokenPasswordLost;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordService {

    private $manager;
    private $user;
    private $tokenPasswordLost;
    private $encoder;

    public function __construct(ManagerRegistry $managerRegistry, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $managerRegistry->getManager();
        $this->user = new User();
        $this->tokenPasswordLost = new TokenPasswordLost();
        $this->encoder = $encoder;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTokenPasswordLost()
    {
        return $this->tokenPasswordLost->getToken();
    }

    public function generateToken()
    {
        try {
            $token = bin2hex(random_bytes(64));
        } catch (\Exception $e) {
            return false;
        }
        $this->tokenPasswordLost->setToken($token);
        return true;
    }

    public function getUserByEmail($email)
    {
        return $this->manager->getRepository(User::class)->findUserByEmailDB($email);
    }

    public function getActiveTokenByUser($user)
    {
        return $this->manager->getRepository(TokenPasswordLost::class)->findAllTokenAvailableForUser($user);
    }

    public function setToken($token)
    {
        $this->tokenPasswordLost->setToken($token);
    }

    public function setUserToken($user)
    {
        $this->tokenPasswordLost->setUser($user);
    }

    public function setExpirationDateToken($dateExpiration)
    {
        $this->tokenPasswordLost->setExpirationDate($dateExpiration);
    }

    public function saveTokenDatabase()
    {
        $this->manager->persist($this->tokenPasswordLost);
        $this->manager->flush();
    }

    public function passwordLost($email, $message = "")
    {
        $userPasswordLost = $this->getUserByEmail($email);

        $activeTokens = $this->getActiveTokenByUser($userPasswordLost);

        $this->generateToken();

        $this->tokenPasswordLost->setToken($this->getTokenPasswordLost());
        $this->tokenPasswordLost->setExpirationDate($this->getDateExpiration());
        $this->tokenPasswordLost->setUser($userPasswordLost);

        $this->saveTokenDatabase();

        return $message = "Token change password generated!";
    }

    public function passwordLostErrors()
    {
        /*
        if(!$this->checkUserExist($email)) { return $message = "Ce compte n'existe pas!"; }

        $user = $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($this->getTokenDatabase($user)) { return $message = "Erreur : une demande est toujours en cours!"; };

        if (!$this->generateToken()) { return $message = "Erreur génération token, contacter l'adminitrateur!"; }
        */
    }

    public function checkUserExist($email)
    {
        if (!empty($this->manager->getRepository(TokenPasswordLost::class)->findAllTokenAvailableForUser(['email' => $email])))
        {
            return true;
        }
        return false;
    }

    public function getTokenDatabase($user)
    {
        $tokens = $this->manager->getRepository(TokenPasswordLost::class)->findBy($user,$this->getDateNow());

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

    public function passwordRecovery($newPassword, $token, $message = "")
    {
        if(!$this->tokenIsValid($token)) { return $message = "Token invalide"; }

        $user = $this->getUserByToken($token);

        dump($user);
        die();

        $this->changePassword($user, $newPassword);

        dump("mdp changed");
        die();

        $this->setTokenUsed($token);

        return $message;
    }

    public function tokenIsValid($token)
    {
        if(empty($token)) { return false; }
        if (!empty($this->manager->getRepository(TokenPasswordLost::class)->findBy(['token' => $token])))
        {
            return true;
        }
        return false;
    }

    public function setTokenUsed($token)
    {
        #pass
    }

    public function changePassword($user, $newPassword)
    {
        dump($user);
        die();
        $user->setPassword($this->encoder->encodePassword($user,$newPassword));

        die();

        $user->setPassword($this->encoder->encodePassword($user,$newPassword));
        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function getUserByToken($token)
    {
        $user = $this->manager->getRepository(User::class)->findUserByToken($token);

        return $user;
    }

}