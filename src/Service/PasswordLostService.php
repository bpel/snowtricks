<?php

namespace App\Service;

use App\Entity\TokenPasswordLost;
use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordLostService {

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

    public function getToken()
    {
        try {
            $token =  bin2hex(random_bytes(64));
        } catch (\Exception $e) {
            return false;
        }
        return $token;
    }

    public function getDateExpiration()
    {
        try {
            $dateExpiration =  new \DateTime('now');
            return $dateExpiration->modify('+30 minutes');
        } catch (\Exception $e) {
            return false;
        }
    }

    public function tokenDateExpirationPassed($expirationDateToken)
    {
        $diff = date_diff($this->dateNow,$expirationDateToken);
        $diffMin = $diff->i + ($diff->h/60);
        return ($diffMin < 30);
    }

    public function passwordLost($email)
    {
        $user = $this->manager->getRepository(User::class)->findUserByEmail($email);

        if(empty($user)) { return "Adresse email invalide"; }

        $tokens = $this->manager->getRepository(TokenPasswordLost::class)->findTokenByUser($user);

        foreach ($tokens as $token) {
            if($this->tokenDateExpirationPassed($token->getExpirationDate())) { return "Une demande de réinitialisation est déjà en cours!"; }
        }

        $tokenPasswordLost = new TokenPasswordLost();
        $tokenPasswordLost->setToken($this->getToken());
        $tokenPasswordLost->setUser($user);
        $tokenPasswordLost->setExpirationDate($this->getDateExpiration());

        $this->manager->persist($tokenPasswordLost);
        $this->manager->flush();
    }

    public function getErrorTokenLost($email)
    {
        $user = $this->manager->getRepository(User::class)->findUserByEmail($email);

        if(empty($user)) { return "Adresse email invalide"; }

        $tokens = $this->manager->getRepository(TokenPasswordLost::class)->findTokenByUser($user);

        foreach ($tokens as $token) {
            if($this->tokenDateExpirationPassed($token->getExpirationDate())) { return "Une demande de réinitialisation est déjà en cours!"; }
        }
        return false;
    }

}