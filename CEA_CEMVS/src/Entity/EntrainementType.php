<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrainementTypeRepository")
 */
class EntrainementType
{
    use IdTrait;

    /**
     * @ORM\OneToMany(targetEntity="Entrainement", mappedBy="$entrainementType")
     */
    private $entrainements;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    public function __construct()
    {
        $this->entrainements = new ArrayCollection();
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

    public function addEntrainement(Entrainement $entrainement) : EntrainementType
    {
        if($this->entrainements->contains($entrainement)){
            return $this;
        }
        $this->entrainements->add($entrainement);
        $entrainement->setEntrainementType($this);
        return $this;
    }

    public function removeEntrainement(Entrainement $entrainement) : EntrainementType
    {
        if (!$this->entrainements->contains($entrainement))
        {
            return $this;
        }
        $this->entrainements->removeElement($entrainement);
        $entrainement->setEntrainementType(null);
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
