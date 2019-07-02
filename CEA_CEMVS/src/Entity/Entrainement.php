<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrainementRepository")
 */
class Entrainement
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Salle;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="tireurEntrainements")
     */
    private $tireurProfils;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="maEntrainements")
     */
    private $maProfils;

    /**
     * @var EntrainementType
     * @ORM\ManyToOne(targetEntity="EntrainementType", inversedBy="entrainements")
     */

    private $entrainementType;

    public function __construct()
    {
        $this->tireurProfils = new ArrayCollection();
        $this->maProfils = new ArrayCollection();
    }


    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->Salle;
    }

    public function setSalle(string $Salle): self
    {
        $this->Salle = $Salle;

        return $this;
    }

    public function addTireurProfil(User $user) : Entrainement
    {
        if($this->tireurProfils->contains($user)){
            return $this;
        }
        $this->tireurProfils->add($user);
        $user->addTireurEntrainement($this);
        return $this;
    }

    public function removeTireurProfil(User $user) : Entrainement
    {
        if (!$this->tireurProfils->contains($user))
        {
            return $this;
        }
        $this->tireurProfils->removeElement($user);
        $user->removeTireurEntrainement($this);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getTireurProfils()
    {
        return $this->tireurProfils;
    }

    public function addMaProfil(User $user) : Entrainement
    {
        if($this->maProfils->contains($user)){
            return $this;
        }
        $this->maProfils->add($user);
        $user->addMaEntrainement($this);
        return $this;
    }

    public function removeMaProfil(User $user) : Entrainement
    {
        if (!$this->maProfils->contains($user))
        {
            return $this;
        }
        $this->maProfils->removeElement($user);
        $user->removeMaEntrainement($this);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getMaProfils()
    {
        return $this->maProfils;
    }

    /**
     * @return EntrainementType
     */
    public function getEntrainementType(): ?EntrainementType
    {
        return $this->entrainementType;
    }

    /**
     * @param EntrainementType $entrainementType
     */
    public function setEntrainementType(?EntrainementType $entrainementType): void
    {
        $this->entrainementType = $entrainementType;
    }



}
