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

    public function __construct(ManagerRegistry $managerRegistry, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $managerRegistry->getManager();
        $this->user = new User();
        $this->tokenPasswordLost = new TokenPasswordLost();
        $this->encoder = $encoder;
    }

    public function passwordRecovery($newPassword, $token, $message = "")
    {
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
}