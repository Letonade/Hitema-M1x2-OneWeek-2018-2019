<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeconRepository")
 */
class Lecon
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TexteTireur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TexteMaitre;

    public function getTexteTireur(): ?string
    {
        return $this->TexteTireur;
    }

    public function setTexteTireur(string $TexteTireur): self
    {
        $this->TexteTireur = $TexteTireur;

        return $this;
    }

    public function getTexteMaitre(): ?string
    {
        return $this->TexteMaitre;
    }

    public function setTexteMaitre(?string $TexteMaitre): self
    {
        $this->TexteMaitre = $TexteMaitre;

        return $this;
    }
}
