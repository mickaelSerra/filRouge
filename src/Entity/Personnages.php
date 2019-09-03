<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnagesRepository")
 */
class Personnages
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
    private $Photos;

    /**
     * @ORM\Column(type="text")
     */
    private $Biographie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jeux", inversedBy="personnages")
     */
    private $jeux;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_de_naissance;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getPhotos(): ?string
    {
        return $this->Photos;
    }

    public function setPhotos(string $Photos): self
    {
        $this->Photos = $Photos;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->Biographie;
    }

    public function setBiographie(string $Biographie): self
    {
        $this->Biographie = $Biographie;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }/**
 * @return mixed
 */
public function getJeux()
{
    return $this->jeux;
}/**
 * @param mixed $jeux
 */
public function setJeux($jeux): void
{
    $this->jeux = $jeux;
}

public function getDateDeNaissance(): ?\DateTimeInterface
{
    return $this->Date_de_naissance;
}

public function setDateDeNaissance(\DateTimeInterface $Date_de_naissance): self
{
    $this->Date_de_naissance = $Date_de_naissance;

    return $this;
}


}

