<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlatformVideoRepository")
 */
class PlatformVideo
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
    private $namePlatform;

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
    public function getNamePlatform()
    {
        return $this->namePlatform;
    }

    /**
     * @param mixed $namePlatform
     */
    public function setNamePlatform($namePlatform): void
    {
        $this->namePlatform = $namePlatform;
    }


}
