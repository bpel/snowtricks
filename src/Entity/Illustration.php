<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IllustrationRepository")
 */
class Illustration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkIllustration;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLinkIllustration()
    {
        return $this->linkIllustration;
    }

    /**
     * @param mixed $linkIllustration
     */
    public function setLinkIllustration($linkIllustration): void
    {
        $this->linkIllustration = $linkIllustration;
    }



}
