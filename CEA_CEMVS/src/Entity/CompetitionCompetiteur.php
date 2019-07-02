<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionCompetiteurRepository")
 */
class CompetitionCompetiteur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Placement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlacement(): ?int
    {
        return $this->Placement;
    }

    public function setPlacement(?int $Placement): self
    {
        $this->Placement = $Placement;

        return $this;
    }
}
