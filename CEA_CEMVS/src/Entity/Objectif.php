<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjectifRepository")
 */
class Objectif
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Etats;

    /**
     * @ORM\Column(type="text")
     */
    private $Descriptif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Validation;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sujetObjectifs")
     */
    private $profilSujet;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="auteurObjectifs")
     */
    private $profilAuteur;

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getEtats(): ?string
    {
        return $this->Etats;
    }

    public function setEtats(?string $Etats): self
    {
        $this->Etats = $Etats;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->Descriptif;
    }

    public function setDescriptif(string $Descriptif): self
    {
        $this->Descriptif = $Descriptif;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->Validation;
    }

    public function setValidation(bool $Validation): self
    {
        $this->Validation = $Validation;

        return $this;
    }

    /**
     * @return User
     */
    public function getProfilSujet(): ?User
    {
        return $this->profilSujet;
    }

    /**
     * @param User $profilSujet
     */
    public function setProfilSujet(?User $profilSujet): void
    {
        $this->profilSujet = $profilSujet;
    }

    /**
     * @return User
     */
    public function getProfilAuteur(): User
    {
        return $this->profilAuteur;
    }

    /**
     * @param User $profilAuteur
     */
    public function setProfilAuteur(?User $profilAuteur): void
    {
        $this->profilAuteur = $profilAuteur;
    }



}
