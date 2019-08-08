<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeTrickRepository")
 */
class TypeTrick
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
    private $nameTypetrick;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="typeTrick")
     */
    private $description;

    public function __construct()
    {
        $this->description = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTypetrick(): ?string
    {
        return $this->nameTypetrick;
    }

    public function setNameTypetrick(string $nameTypetrick): self
    {
        $this->nameTypetrick = $nameTypetrick;

        return $this;
    }

    /**
     * @return Collection|Trick[]
     */
    public function getDescription(): Collection
    {
        return $this->description;
    }

    public function addDescription(Trick $description): self
    {
        if (!$this->description->contains($description)) {
            $this->description[] = $description;
            $description->setTypeTrick($this);
        }

        return $this;
    }

    public function removeDescription(Trick $description): self
    {
        if ($this->description->contains($description)) {
            $this->description->removeElement($description);
            // set the owning side to null (unless already changed)
            if ($description->getTypeTrick() === $this) {
                $description->setTypeTrick(null);
            }
        }

        return $this;
    }
}
