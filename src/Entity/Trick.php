<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

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
     * @ORM\ManyToOne(targetEntity="TypeTrick", fetch="EAGER",cascade={"persist"})
     * @JoinColumn(name="typeTrick", referencedColumnName="id")
     */
    private $typeTrick;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Illustration", fetch="EAGER",cascade={"persist"})
     * @JoinColumn(name="illustration", referencedColumnName="id")
     */
    private $illustration;

    /**
     * @ORM\ManyToMany(targetEntity="Video", fetch="EAGER",cascade={"persist"})
     * @JoinColumn(name="video", referencedColumnName="id")
     */
    private $video;

    public function __construct()
    {
        $this->video = new ArrayCollection();
        $this->illustration = new ArrayCollection();
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
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video): void
    {
        $this->video = $video;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->video->contains($video)) {
            $this->video->removeElement($video);
        }

        return $this;
    }

    /**
     * @return Collection|Illustration[]
     */
    public function getIllustration(): Collection
    {
        return $this->illustration;
    }

    public function addIllustration(Illustration $illustration): self
    {
        if (!$this->illustration->contains($illustration)) {
            $this->illustration[] = $illustration;
        }

        return $this;
    }

    public function removeIllustration(Illustration $illustration): self
    {
        if ($this->illustration->contains($illustration)) {
            $this->illustration->removeElement($illustration);
        }

        return $this;
    }

}
