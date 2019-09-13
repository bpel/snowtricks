<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nameUser;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastnameUser;

    /**
     * @ORM\ManyToOne(targetEntity="Illustration", fetch="EAGER",cascade={"persist"})
     * @JoinColumn(name="illustration", referencedColumnName="id", nullable=true)
     */
    private $illustration;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $password;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getNameUser()
    {
        return $this->nameUser;
    }

    /**
     * @param mixed $nameUser
     */
    public function setNameUser($nameUser): void
    {
        $this->nameUser = $nameUser;
    }

    /**
     * @return mixed
     */
    public function getLastnameUser()
    {
        return $this->lastnameUser;
    }

    public function getFullName()
    {
        return $this->getLastnameUser().' '.$this->getNameUser();
    }

    /**
     * @param mixed $lastnameUser
     */
    public function setLastnameUser($lastnameUser): void
    {
        $this->lastnameUser = $lastnameUser;
    }

    /**
     * @return mixed
     */
    public function getIllustration()
    {
        return $this->illustration;
    }

    /**
     * @param mixed $illustration
     */
    public function setIllustration($illustration): void
    {
        $this->illustration = $illustration;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getFullName();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
