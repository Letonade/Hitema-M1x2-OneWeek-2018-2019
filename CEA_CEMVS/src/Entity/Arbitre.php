<?php

namespace App\Entity;

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
     * @ORM\OneToOne(targetEntity="User", mappedBy="arbitre")
     */
    private $profil;

    /**
     * @return ArbitreNiveau
     */
    public function getNiveau(): ArbitreNiveau
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




}
