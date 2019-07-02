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
     * @ORM\ManyToMany(targetEntity="Entrainement", inversedBy="tireurProfils")
     * @ORM\JoinTable(name="entrainement_tireur")
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
     * @var Arbitre
     * @ORM\OneToOne(targetEntity="Arbitre", inversedBy="profil")
     */
    private $arbitre;

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

    public function __construct()
    {
        $this->auteurObjectifs = new ArrayCollection();
        $this->sujetObjectifs = new ArrayCollection();
        $this->tireurEntrainements = new ArrayCollection();
        $this->maEntrainements = new ArrayCollection();
        $this->arbitreCompetitions = new ArrayCollection();
        $this->encadrantCompetitions = new ArrayCollection();

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
    public function setPassword(string $password): void
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

    public function addTireurEntrainement(Entrainement $entrainement) : User
    {
        if($this->tireurEntrainements->contains($entrainement)){
            return $this;
        }
        $this->tireurEntrainements->add($entrainement);
        $entrainement->addTireurProfil($this);
        return $this;
    }

    public function removeTireurEntrainement(Entrainement $entrainement) : User
    {
        if (!$this->tireurEntrainements->contains($entrainement))
        {
            return $this;
        }
        $this->tireurEntrainements->removeElement($entrainement);
        $entrainement->removeTireurProfil($this);
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

    /**
     * @return Arbitre
     */
    public function getArbitre(): Arbitre
    {
        return $this->arbitre;
    }

    /**
     * @param Arbitre $arbitre
     */
    public function setArbitre(Arbitre $arbitre): void
    {
        $this->arbitre = $arbitre;
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
   

}