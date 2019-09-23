<?php

namespace App\Service;

use App\Entity\TokenPasswordLost;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordRecoveryService {

    private $manager;
    private $user;
    private $tokenPasswordLost;
    private $encoder;
    private $dateNow;

    public function __construct(ManagerRegistry $managerRegistry, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $managerRegistry->getManager();
        $this->user = new User();
        $this->tokenPasswordLost = new TokenPasswordLost();
        $this->encoder = $encoder;
        try {
            $this->dateNow = new \DateTime('now');
        } catch (\Exception $e) {
        }
    }

    public function tokenExpired($expirationDateToken)
    {
        $diff = date_diff($this->dateNow,$expirationDateToken);
        $diffMin = $diff->i + ($diff->h/60);
        return ($diffMin > 30);
    }

    public function passwordRecovery($newPassword, $token, $message = "")
    {
        if(!$this->tokenIsValid($token)) { return "Token invalide"; }

        $token = $this->manager->getRepository(TokenPasswordLost::class)->findToken($token);
        $token->setUsed(true);
        $user = $token->getUser();
        $user->setPassword($this->encoder->encodePassword($user,$newPassword));

        $this->manager->persist($token);
        $this->manager->persist($user);
        $this->manager->flush();

        return $message;
    }

    public function tokenIsValid($tokenForm)
    {
        $token = $this->manager->getRepository(TokenPasswordLost::class)->findToken($tokenForm);

        if(empty($token)) { return false; }
        if($token->getUsed() == true) { return false; }
        if($this->tokenExpired($token->getExpirationDate())) { return false; }

        return true;
    }

    public function getErrorTokenRecovery($tokenForm, $error = "")
    {
        $token = $this->manager->getRepository(TokenPasswordLost::class)->findToken($tokenForm);

        if(empty($token)) { return "Token invalide"; }
        if($token->getUsed() == true) { return "Token déjà utilisé."; }
        if($this->tokenExpired($token->getExpirationDate())) { return "Token expiré"; }
        return $error;
    }
}