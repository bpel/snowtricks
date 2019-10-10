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
 * @UniqueEntity("nameTrick")
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
     * @Assert\NotBlank
     */
    private $nameTrick;

    /**
     * @ORM\ManyToOne(targetEntity="TypeTrick", fetch="LAZY",cascade={"persist"})
     * @JoinColumn(name="typeTrick", referencedColumnName="id")
     * @Assert\NotNull
     */
    private $typeTrick;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotNull
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Message", fetch="EAGER",cascade={"persist"})
     * @JoinColumn(name="message", referencedColumnName="id", onDelete="CASCADE")
     */
    private $messages;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->illustrations = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

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
    public function getNameTrick()
    {
        return $this->nameTrick;
    }

    /**
     * @param mixed $nameTrick
     */
    public function setNameTrick($nameTrick): void
    {
        $this->nameTrick = $nameTrick;
    }

    /**
     * @return mixed
     */
    public function getTypeTrick()
    {
        return $this->typeTrick;
    }

    /**
     * @param mixed $typeTrick
     */
    public function setTypeTrick($typeTrick): void
    {
        $this->typeTrick = $typeTrick;
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

    public function addIllustration(Illustration $illustration): self
    {
        if (!$this->illustrations->contains($illustration)) {
            $this->illustrations[] = $illustration;
        }

        return $this;
    }

    public function removeIllustration(Illustration $illustration): self
    {
        if ($this->illustrations->contains($illustration)) {
            $this->illustrations->removeElement($illustration);
        }

        return $this;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
        }

        return $this;
    }

}
