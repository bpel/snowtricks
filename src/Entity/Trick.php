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

}
