<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 28/11/2018
 * Time: 13:11
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity()
 */

class User implements UserInterface
{

    use IdTrait;
    /**
     * @var  string
     * @ORM\Column(unique=true,length=191)
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Length(max=191)
     */
    private $login;
    /**
     * @var  string
     * @ORM\Column()
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $password;
    /**
     * @var  string
     * @ORM\Column()
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $nom;
    /**
     * @var  string
     * @ORM\Column()
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $prenom;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     */
    private $role=1;

    /**
     * @ORM\OneToMany(targetEntity="Objectif", mappedBy="profilSujet")
     */
    private $sujetObjectifs;

    /**
     * @ORM\OneToMany(targetEntity="Objectif", mappedBy="profilAuteur")
     */
    private $auteurObjectifs;

    /**
     * @ORM\OneToMany(targetEntity="EntrainementTireur", mappedBy="tireur")
     *
     */
    private $tireurEntrainements;

    /**
     * @ORM\ManyToMany(targetEntity="Entrainement", inversedBy="maProfils")
     * @ORM\JoinTable(name="entrainement_ma")
     */
    private $maEntrainements;

    /**
     * @var ProfilCategorie
     * @ORM\ManyToOne(targetEntity="ProfilCategorie", inversedBy="profils")
     */
    private $profilCategorie;

    /**
     * @ORM\ManyToMany(targetEntity="Arbitre", inversedBy="profils")
     */
    private $arbitres;

    /**
     * @ORM\ManyToMany(targetEntity="Competition", mappedBy="arbitres")
     *
     */
    private $arbitreCompetitions;

    /**
     * @ORM\ManyToMany(targetEntity="Competition", mappedBy="encadrants")
     *
     */
    private $encadrantCompetitions;

    /**
     * @ORM\OneToMany(targetEntity="Lecon", mappedBy="ma")
     */
    private $maLecons;

    /**
     * @ORM\OneToMany(targetEntity="Lecon", mappedBy="tireur")
     */
    private $tireurLecons;

    /**
     * @var TireurGroupe
     * @ORM\ManyToOne(targetEntity="TireurGroupe", inversedBy="profils")
     */
    private $tireurGroupe;

    public function __construct()
    {
        $this->auteurObjectifs = new ArrayCollection();
        $this->sujetObjectifs = new ArrayCollection();
        $this->tireurEntrainements = new ArrayCollection();
        $this->maEntrainements = new ArrayCollection();
        $this->arbitreCompetitions = new ArrayCollection();
        $this->encadrantCompetitions = new ArrayCollection();
        $this->maLecons = new ArrayCollection();
        $this->tireurLecons = new ArrayCollection();
        $this->arbitres = new ArrayCollection();

    }

    public function addSujetObjectif(Objectif $objectif) : User
    {
        if($this->sujetObjectifs->contains($objectif)){
            return $this;
        }
        $this->sujetObjectifs->add($objectif);
        $objectif->setProfilSujet($this);
        return $this;
    }

    public function removeSujetObjectif(Objectif $objectif) : User
    {
        if (!$this->sujetObjectifs->contains($objectif))
        {
            return $this;
        }
        $this->sujetObjectifs->removeElement($objectif);
        $objectif->setProfilSujet(null);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getSujetObjectifs()
    {
        return $this->sujetObjectifs;
    }

    public function addAuteurObjectif(Objectif $objectif) : User
    {
        if($this->auteurObjectifs->contains($objectif)){
            return $this;
        }
        $this->auteurObjectifs->add($objectif);
        $objectif->setProfilAuteur($this);
        return $this;
    }

    public function removeAuteurObjectif(Objectif $objectif) : User
    {
        if (!$this->auteurObjectifs->contains($objectif))
        {
            return $this;
        }
        $this->auteurObjectifs->removeElement($objectif);
        $objectif->setProfilAuteur(null);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getAuteurObjectifs()
    {
        return $this->auteurObjectifs;
    }

    /**
     * @return string
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }



    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @param string $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param int $role
     */
    public function setRole(int $role): void
    {
        $this->role = $role;
    }



    public function getRoles()
    {
        switch ($this->role)
        {
            case 1: return ['ROLE_USER'];
            case 2: return ['ROLE_MODO'];
            case 3: return ['ROLE_ADMIN'];
        }
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }



    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function addTireurEntrainement(EntrainementTireur $entrainementTireur) : User
    {
        if($this->tireurEntrainements->contains($entrainementTireur)){
            return $this;
        }
        $this->tireurEntrainements->add($entrainementTireur);
        return $this;
    }

    public function removeTireurEntrainement(EntrainementTireur $entrainementTireur) : User
    {
        if (!$this->tireurEntrainements->contains($entrainementTireur))
        {
            return $this;
        }
        $this->tireurEntrainements->removeElement($entrainementTireur);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getTireurEntrainements()
    {
        return $this->tireurEntrainements;
    }

    public function addMaEntrainement(Entrainement $entrainement) : User
    {
        if($this->maEntrainements->contains($entrainement)){
            return $this;
        }
        $this->maEntrainements->add($entrainement);
        $entrainement->addMaProfil($this);
        return $this;
    }

    public function removeMaEntrainement(Entrainement $entrainement) : User
    {
        if (!$this->maEntrainements->contains($entrainement))
        {
            return $this;
        }
        $this->maEntrainements->removeElement($entrainement);
        $entrainement->removeMaProfil($this);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getMaEntrainements()
    {
        return $this->maEntrainements;
    }

    /**
     * @return ProfilCategorie
     */
    public function getProfilCategorie(): ProfilCategorie
    {
        return $this->profilCategorie;
    }

    /**
     * @param ProfilCategorie $profilCategorie
     */
    public function setProfilCategorie(?ProfilCategorie $profilCategorie): void
    {
        $this->profilCategorie = $profilCategorie;
    }


    public function addArbitreCompetition(Competition $competition) : User
    {
        if($this->arbitreCompetitions->contains($competition)){
            return $this;
        }
        $this->arbitreCompetitions->add($competition);
        $competition->addArbitre($this);
        return $this;
    }

    public function removeArbitreCompetition(Competition $competition) : User
    {
        if (!$this->arbitreCompetitions->contains($competition))
        {
            return $this;
        }
        $this->arbitreCompetitions->removeElement($competition);
        $competition->removeArbitre($this);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getArbitreCompetitions()
    {
        return $this->arbitreCompetitions;
    }

    public function addArbitre(Arbitre $arbitre) : User
    {
        if ($this->arbitres->contains($arbitre))
        {
            return $this;
        }
        $this->arbitres->add($arbitre);
        $arbitre->addProfile($this);
        return $this;

    }

    public function removeArbitre(Arbitre $arbitre) : User
    {
        if (!$this->arbitres->contains($arbitre))
        {
            return $this;
        }
        $this->arbitres->removeElement($arbitre);
        $arbitre->removeProfile($this);
        return $this;
    }


    public function getArbitres()
    {
        return $this->arbitres;
    }



    public function addEncadrantCompetition(Competition $competition) : User
    {
        if($this->encadrantCompetitions->contains($competition)){
            return $this;
        }
        $this->encadrantCompetitions->add($competition);
        $competition->addEncadrant($this);
        return $this;
    }

    public function removeEncadrantCompetition(Competition $competition) : User
    {
        if (!$this->encadrantCompetitions->contains($competition))
        {
            return $this;
        }
        $this->encadrantCompetitions->removeElement($competition);
        $competition->removeEncadrant($this);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getEncadrantCompetitions()
    {
        return $this->encadrantCompetitions;
    }




    public function addTireurLecon(Lecon $lecon) : User
    {
        if($this->tireurLecons->contains($lecon)){
            return $this;
        }
        $this->tireurLecons->add($lecon);
        $lecon->setTireur($this);
        return $this;
    }

    public function removeTireurLecon(Lecon $lecon) : User
    {
        if (!$this->tireurLecons->contains($lecon))
        {
            return $this;
        }
        $this->tireurLecons->removeElement($lecon);
        $lecon->setTireur(null);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getTireurLecons()
    {
        return $this->tireurLecons;
    }



    public function addMaLecon(Lecon $lecon) : User
    {
        if($this->maLecons->contains($lecon)){
            return $this;
        }
        $this->maLecons->add($lecon);
        $lecon->setMa($this);
        return $this;
    }

    public function removeMaLecon(Lecon $lecon) : User
    {
        if (!$this->maLecons->contains($lecon))
        {
            return $this;
        }
        $this->maLecons->removeElement($lecon);
        $lecon->setMa(null);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getMaLecons()
    {
        return $this->maLecons;
    }

    /**
     * @param mixed $maLecons
     */
    public function setMaLecons($maLecons): void
    {
        $this->maLecons = $maLecons;
    }

    /**
     * @return TireurGroupe
     */
    public function getTireurGroupe(): TireurGroupe
    {
        return $this->tireurGroupe;
    }

    /**
     * @param TireurGroupe $tireurGroupe
     */
    public function setTireurGroupe(TireurGroupe $tireurGroupe): void
    {
        $this->tireurGroupe = $tireurGroupe;
    }




}