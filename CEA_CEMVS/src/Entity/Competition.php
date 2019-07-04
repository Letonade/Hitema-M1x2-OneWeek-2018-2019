<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionRepository")
 */
class Competition
{
    use IdTrait;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateFin;

    /**
     * @ORM\ManyToMany(targetEntity="ProfilCategorie", inversedBy="competitions")
     */
    private $profilsCategories;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="arbitreCompetitions")
     * @ORM\JoinTable(name="arbitre_competition")
     */
    private $arbitres;
    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="encadrantCompetitions")
     * @ORM\JoinTable(name="encadrant_competition")
     */
    private $encadrants;

    /**
     * @ORM\OneToMany(targetEntity="CompetitionCompetiteur", mappedBy="competition")
     */
    private $competiteurCompetitions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    public function __construct()
    {
        $this->profilsCategories = new ArrayCollection();
        $this->arbitres = new ArrayCollection();
        $this->encadrants = new ArrayCollection();
        $this->competiteurCompetitions = new ArrayCollection();
    }


    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function addProfilCategorie(ProfilCategorie $profilCategorie) : Competition
    {
        if($this->profilsCategories->contains($profilCategorie)){
            return $this;
        }
        $this->profilsCategories->add($profilCategorie);
        $profilCategorie->addCompetition($this);
        return $this;
    }

    public function removeProfilCategorie(ProfilCategorie $profilCategorie) : Competition
    {
        if (!$this->profilsCategories->contains($profilCategorie))
        {
            return $this;
        }
        $this->profilsCategories->removeElement($profilCategorie);
        $profilCategorie->removeCompetition($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfilsCategories()
    {
        return $this->profilsCategories;
    }


    public function addArbitre(User $user) : Competition
    {
        if($this->arbitres->contains($user)){
            return $this;
        }
        $this->arbitres->add($user);
        $user->addArbitreCompetition($this);
        return $this;
    }

    public function removeArbitre(User $user) : Competition
    {
        if (!$this->arbitres->contains($user))
        {
            return $this;
        }
        $this->arbitres->removeElement($user);
        $user->removeArbitreCompetition($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArbitres()
    {
        return $this->arbitres;
    }

    public function addEncadrant(User $user) : Competition
    {
        if($this->encadrants->contains($user)){
            return $this;
        }
        $this->encadrants->add($user);
        $user->addEncadrantCompetition($this);
        return $this;
    }

    public function removeEncadrant(User $user) : Competition
    {
        if (!$this->encadrants->contains($user))
        {
            return $this;
        }
        $this->encadrants->removeElement($user);
        $user->removeEncadrantCompetition($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEncadrants()
    {
        return $this->encadrants;
    }

    public function addCompetitionCompetiteur(CompetitionCompetiteur $competitionCompetiteur) : Competition
    {
        if($this->competiteurCompetitions->contains($competitionCompetiteur)){
            return $this;
        }
        $this->competiteurCompetitions->add($competitionCompetiteur);
        return $this;
    }

    public function removeCompetitionCompititeur(CompetitionCompetiteur $competitionCompetiteur) : Competition
    {
        if (!$this->competiteurCompetitions->contains($competitionCompetiteur))
        {
            return $this;
        }
        $this->competiteurCompetitions->remove($competitionCompetiteur);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompetiteurCompetitions()
    {
        return $this->competiteurCompetitions;
    }



    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }




}
