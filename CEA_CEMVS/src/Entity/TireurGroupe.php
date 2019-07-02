<?php

namespace App\Entity;

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

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }
}
