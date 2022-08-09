<?php

namespace App\Entity;

use App\Repository\PicturesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PicturesRepository::class)
 */
class Pictures
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
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
     * @ORM\Column (type="string")
     */
    private $picture;

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }


    /**
     * @param mixed $picture
     */
    public function setPicture($picture): void
    {
        $this->picture = $picture;
    }
}
