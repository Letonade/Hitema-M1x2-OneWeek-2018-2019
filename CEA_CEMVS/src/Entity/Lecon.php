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

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="maLecons")
     */

    private $ma;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tireurLecons")
     */

    private $tireur;

    /**
     * @var Entrainement
     * @ORM\ManyToOne(targetEntity="Entrainement", inversedBy="lecons")
     */

    private $entrainement;

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

    /**
     * @return User
     */
    public function getMa(): ?User
    {
        return $this->ma;
    }

    /**
     * @param User $ma
     */
    public function setMa(?User $ma): void
    {
        $this->ma = $ma;
    }

    /**
     * @return User
     */
    public function getTireur(): ?User
    {
        return $this->tireur;
    }

    /**
     * @param User $tireur
     */
    public function setTireur(?User $tireur): void
    {
        $this->tireur = $tireur;
    }

    /**
     * @return Entrainement
     */
    public function getEntrainement(): ?Entrainement
    {
        return $this->entrainement;
    }

    /**
     * @param Entrainement $entrainement
     */
    public function setEntrainement(?Entrainement $entrainement): void
    {
        $this->entrainement = $entrainement;
    }


}
