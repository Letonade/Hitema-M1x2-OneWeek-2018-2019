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

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="competiteurCompetitions")
     */

    private $profil;

    /**
     * @var Competition
     * @ORM\ManyToOne(targetEntity="Competition", inversedBy="competiteurCompetitions")
     */

    private $competition;

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

    /**
     * @return User
     */
    public function getProfil(): ?User
    {
        return $this->profil;
    }

    /**
     * @param User $profil
     */
    public function setProfil(?User $profil): void
    {
        $this->profil = $profil;
    }

    /**
     * @return Competition
     */
    public function getCompetition(): Competition
    {
        return $this->competition;
    }

    /**
     * @param Competition $competition
     */
    public function setCompetition(Competition $competition): void
    {
        $this->competition = $competition;
    }


}
