<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfilCategorieRepository")
 */
class ProfilCategorie
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="profilCategorie")
     */
    private $profils;

    /**
     * @ORM\ManyToMany(targetEntity="Competition", mappedBy="profilsCategories")
     */
    private $competitions;

    public function __construct()
    {
        $this->profils = new ArrayCollection();
        $this->competitions = new ArrayCollection();
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

    public function addProfil(User $user) : ProfilCategorie
    {
        if($this->profils->contains($user)){
            return $this;
        }
        $this->profils->add($user);
        $user->setProfilCategorie($this);
        return $this;
    }

    public function removeProfile(User $user) : ProfilCategorie
    {
        if (!$this->profils->contains($user))
        {
            return $this;
        }
        $this->profils->removeElement($user);
        $user->setProfilCategorie(null);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getProfils()
    {
        return $this->profils;
    }

    public function addCompetition(Competition $competition) : ProfilCategorie
    {
        if($this->competitions->contains($competition)){
            return $this;
        }
        $this->competitions->add($competition);
        $competition->addProfilCategorie($this);
        return $this;
    }

    public function removeCompetition(Competition $competition) : ProfilCategorie
    {
        if (!$this->competitions->contains($competition))
        {
            return $this;
        }
        $this->competitions->removeElement($competition);
        $competition->removeProfilCategorie($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompetitions()
    {
        return $this->competitions;
    }


}
