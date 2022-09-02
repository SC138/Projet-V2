<?php

namespace App\Entity;

use App\Repository\DateUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DateUserRepository::class)
 */
class DateUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="dateUser", cascade={"persist", "remove"})
     */
    private $Relation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateMeet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelation(): ?User
    {
        return $this->Relation;
    }

    public function setRelation(?User $Relation): self
    {
        $this->Relation = $Relation;

        return $this;
    }

    public function getDateMeet(): ?\DateTimeInterface
    {
        return $this->DateMeet;
    }

    public function setDateMeet(?\DateTimeInterface $DateMeet): self
    {
        $this->DateMeet = $DateMeet;

        return $this;
    }
}
