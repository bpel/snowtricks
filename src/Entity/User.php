<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Token;

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
     * @ORM\ManyToMany(targetEntity="TokenPasswordLost", fetch="EAGER",cascade={"persist"})
     * @JoinColumn(name="tokenPasswordLost", referencedColumnName="id", nullable=true)
     */
    private $tokenPasswordLost;

    public function __construct()
    {
        $this->tokenPasswordLost = new ArrayCollection();
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNameUser(): ?string
    {
        return $this->nameUser;
    }

    public function setNameUser(string $nameUser): self
    {
        $this->nameUser = $nameUser;

        return $this;
    }

    public function getLastnameUser(): ?string
    {
        return $this->lastnameUser;
    }

    public function setLastnameUser(string $lastnameUser): self
    {
        $this->lastnameUser = $lastnameUser;

        return $this;
    }

    public function getIllustration(): ?Illustration
    {
        return $this->illustration;
    }

    public function setIllustration(?Illustration $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function addTokenPasswordLost(TokenPasswordLost $tokenPasswordLost): self
    {
        if (!$this->tokenPasswordLost->contains($tokenPasswordLost)) {
            $this->tokenPasswordLost[] = $tokenPasswordLost;
        }

        return $this;
    }

    /**
     * @return Collection|TokenPasswordLost[]
     */
    public function getTokenPasswordLost(): Collection
    {
        return $this->tokenPasswordLost;
    }

    public function setTokenPasswordLost(?TokenPasswordLost $tokenPasswordLost): self
    {
        $this->tokenPasswordLost = $tokenPasswordLost;

        return $this;
    }

    public function removeTokenPasswordLost(TokenPasswordLost $tokenPasswordLost): self
    {
        if ($this->tokenPasswordLost->contains($tokenPasswordLost)) {
            $this->tokenPasswordLost->removeElement($tokenPasswordLost);
        }

        return $this;
    }
}
