<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JeuxRepository")
 */
class Jeux
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $plateformes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="text")
     */
    private $synopsis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Personnages", mappedBy="jeux")
     */
    private $personnages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nav_titre;

    public function __construct()
    {
        $this->personnages = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPlateformes(): ?string
    {
        return $this->plateformes;
    }

    public function setPlateformes(string $plateformes): self
    {
        $this->plateformes = $plateformes;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersonnages()
    {
        return $this->personnages;
    }

    public function getNavTitre(): ?string
    {
        return $this->nav_titre;
    }

    public function setNavTitre(string $nav_titre): self
    {
        $this->nav_titre = $nav_titre;

        return $this;
    }

}
