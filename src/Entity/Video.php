<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlatformVideo", fetch="EAGER")
     * @JoinColumn(name="platformVideo", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $platformVideo;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getPlatformVideo()
    {
        return $this->platformVideo;
    }

    /**
     * @param mixed $platformVideo
     */
    public function setPlatformVideo($platformVideo): void
    {
        $this->platformVideo = $platformVideo;
    }



}