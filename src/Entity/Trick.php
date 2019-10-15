<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 * @UniqueEntity("nametrick")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $nametrick;

    /**
     * @ORM\ManyToOne(targetEntity="TypeTrick", fetch="LAZY",cascade={"persist"})
     * @JoinColumn(name="typeTrick", referencedColumnName="id")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $typetrick;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Illustration", fetch="LAZY",cascade={"remove"})
     * @JoinColumn(name="illustrations", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\Valid
     */
    private $illustrations;
    /**
     * @ORM\ManyToMany(targetEntity="Video", fetch="LAZY",cascade={"remove"})
     * @JoinColumn(name="videos", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\Valid
     */
    private $videos;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="trick",cascade={"remove"})
     */
    private $messages;

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
    public function getNametrick()
    {
        return $this->nametrick;
    }

    /**
     * @param mixed $nametrick
     */
    public function setNametrick($nametrick): void
    {
        $this->nametrick = $nametrick;
    }

    /**
     * @return mixed
     */
    public function getTypetrick()
    {
        return $this->typetrick;
    }

    /**
     * @param mixed $typetrick
     */
    public function setTypetrick($typetrick): void
    {
        $this->typetrick = $typetrick;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIllustrations()
    {
        return $this->illustrations;
    }

    /**
     * @param mixed $illustrations
     */
    public function setIllustrations($illustrations): void
    {
        $this->illustrations = $illustrations;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos($videos): void
    {
        $this->videos = $videos;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     */
    public function setMessages($messages): void
    {
        $this->messages = $messages;
    }

}
