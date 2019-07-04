<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TireurGroupeRepository")
 */
class TireurGroupe
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="tireurGroupe")
     */
    private $profils;

    /**
     * @ORM\OneToMany(targetEntity="Entrainement", mappedBy="tireurGroupe")
     */
    private $entrainements;

    public function __construct()
    {
        $this->entrainements = new ArrayCollection();
        $this->profils = new ArrayCollection();
    }

    public function __toString(){
        return $this->Nom;
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

    public function addProfil(User $user) : TireurGroupe
    {
        if($this->profils->contains($user)){
            return $this;
        }
        $this->profils->add($user);
        return $this;
    }

    public function removeProfil(User $user) : TireurGroupe
    {
        if (!$this->profils->contains($user))
        {
            return $this;
        }
        $this->profils->removeElement($user);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getProfils()
    {
        return $this->profils;
    }



    public function addEntrainement(Entrainement $entrainement) : TireurGroupe
    {
        if($this->entrainements->contains($entrainement)){
            return $this;
        }
        $this->entrainements->add($entrainement);
        return $this;
    }

    public function removeEntrainement(Entrainement $entrainement) : TireurGroupe
    {
        if (!$this->entrainements->contains($entrainement))
        {
            return $this;
        }
        $this->entrainements->removeElement($entrainement);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getEntrainements()
    {
        return $this->entrainements;
    }


}
