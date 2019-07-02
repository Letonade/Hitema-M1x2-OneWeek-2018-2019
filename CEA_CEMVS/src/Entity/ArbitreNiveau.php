<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArbitreNiveauRepository")
 */
class ArbitreNiveau
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Arbitre", mappedBy="niveau")
     */
    private $arbitres;

    public function __construct()
    {
        $this->arbitres = new ArrayCollection();
    }

    public function addArbitre(Arbitre $arbitre) : ArbitreNiveau
    {
        if($this->arbitres->contains($arbitre)){
          return $this;
        }
        $this->arbitres->add($arbitre);
        $arbitre->setNiveau($this);
        return $this;
    }

    public function removeArbitre(Arbitre $arbitre) : ArbitreNiveau
    {
        if (!$this->arbitres->contains($arbitre))
        {
            return $this;
        }
        $this->arbitres->removeElement($arbitre);
        $arbitre->setNiveau(null);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getArbitres()
    {
        return $this->arbitres;
    }



    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
