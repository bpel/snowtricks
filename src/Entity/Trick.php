<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
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
     * @ORM\Column(type="string", length=100)
     */
    private $nameTrick;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeTrick", inversedBy="description")
     */
    private $typeTrick;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\IllustrationTrick", mappedBy="idTrick")
     */
    private $illustrationTricks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\VideoTrick", mappedBy="idTrick")
     */
    private $videoTricks;

    public function __construct()
    {
        $this->illustrationTricks = new ArrayCollection();
        $this->videoTricks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTrick(): ?string
    {
        return $this->nameTrick;
    }

    public function setNameTrick(string $nameTrick): self
    {
        $this->nameTrick = $nameTrick;

        return $this;
    }

    public function getTypeTrick(): ?TypeTrick
    {
        return $this->typeTrick;
    }

    public function setTypeTrick(?TypeTrick $typeTrick): self
    {
        $this->typeTrick = $typeTrick;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdIllustration(): ?Illustration
    {
        return $this->idIllustration;
    }

    public function setIdIllustration(?Illustration $idIllustration): self
    {
        $this->idIllustration = $idIllustration;

        return $this;
    }

    public function getUrl(): ?Video
    {
        return $this->url;
    }

    public function setUrl(?Video $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        // set (or unset) the owning side of the relation if necessary
        $newIdTrick = $message === null ? null : $this;
        if ($newIdTrick !== $message->getIdTrick()) {
            $message->setIdTrick($newIdTrick);
        }

        return $this;
    }

    /**
     * @return Collection|IllustrationTrick[]
     */
    public function getIllustrationTricks(): Collection
    {
        return $this->illustrationTricks;
    }

    public function addIllustrationTrick(IllustrationTrick $illustrationTrick): self
    {
        if (!$this->illustrationTricks->contains($illustrationTrick)) {
            $this->illustrationTricks[] = $illustrationTrick;
            $illustrationTrick->addIdTrick($this);
        }

        return $this;
    }

    public function removeIllustrationTrick(IllustrationTrick $illustrationTrick): self
    {
        if ($this->illustrationTricks->contains($illustrationTrick)) {
            $this->illustrationTricks->removeElement($illustrationTrick);
            $illustrationTrick->removeIdTrick($this);
        }

        return $this;
    }

    /**
     * @return Collection|VideoTrick[]
     */
    public function getVideoTricks(): Collection
    {
        return $this->videoTricks;
    }

    public function addVideoTrick(VideoTrick $videoTrick): self
    {
        if (!$this->videoTricks->contains($videoTrick)) {
            $this->videoTricks[] = $videoTrick;
            $videoTrick->addIdTrick($this);
        }

        return $this;
    }

    public function removeVideoTrick(VideoTrick $videoTrick): self
    {
        if ($this->videoTricks->contains($videoTrick)) {
            $this->videoTricks->removeElement($videoTrick);
            $videoTrick->removeIdTrick($this);
        }

        return $this;
    }
}
