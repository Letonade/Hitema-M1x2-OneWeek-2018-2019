<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrainementTireurRepository")
 */
class EntrainementTireur
{
    use IdTrait;

    /**
     * @ORM\Column(type="boolean")
     */
    private $presence;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tireurEntrainements")
     */

    private $tireur;
    /**
     * @var Entrainement
     * @ORM\ManyToOne(targetEntity="Entrainement", inversedBy="tireurProfils")
     */

    private $entrainement;

    public function getPresence(): ?bool
    {
        return $this->presence;
    }

    public function setPresence(bool $presence): self
    {
        $this->presence = $presence;

        return $this;
    }
}
