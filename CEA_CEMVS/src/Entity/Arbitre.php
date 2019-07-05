<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArbitreRepository")
 */
class Arbitre
{
    use IdTrait;

    /**
     * @var ArbitreNiveau
     * @ORM\ManyToOne(targetEntity="ArbitreNiveau", inversedBy="arbitres")
     */

    private $niveau;

    /**
     * @var User
     * @ORM\ManyToMany(targetEntity="User", mappedBy="arbitres")
     */
    private $profils;

    public function __construct()
    {
        $this->profils = new ArrayCollection();
    }


    /**
     * @return ArbitreNiveau
     */
    public function getNiveau(): ?ArbitreNiveau
    {
        return $this->niveau;
    }

    /**
     * @param ArbitreNiveau $niveau
     */
    public function setNiveau(?ArbitreNiveau $niveau): void
    {
        $this->niveau = $niveau;
    }

    public function addProfil(User $user): Arbitre
    {
        if ($this->profils->contains($user))
        {
            return $this;
        }
        $this->profils->add($user);
        $user->addArbitre($this);
        return $this;
    }

    public function removeProfil(User $user):Arbitre
    {
        if (!$this->profils->contains($user))
        {
            return $this;

        }
        $this->profils->removeElement($user);
        $user->removeArbitre($this);
        return $this;
    }

    /**
     * @return User
     */
    public function getProfils(): User
    {
        return $this->profils;
    }


}
