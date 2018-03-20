<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Membre
 *
 * @ORM\Table(name="membre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MembreRepository")
 * @UniqueEntity(fields="pseudo", message="Ce pseudo est déjà utilisé")
 * @UniqueEntity(fields="email", message="Cet email est déjà utilisé")
 */
class Membre implements UserInterface {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * Assert\NotBlank()
     * @ORM\Column(name="pseudo", type="string", length=20, unique=true)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=60)
     */
    private $mdp;

    /**
     * @var string
     * Assert\NotBlank()
     * @ORM\Column(name="nom", type="string", length=20)
     */
    private $nom;

    /**
     * @var string
     * Assert\NotBlank()
     * @ORM\Column(name="prenom", type="string", length=20)
     */
    private $prenom;

    /**
     * @var string
     * Assert\NotBlank()
     * Assert\Email()
     * @ORM\Column(name="email", type="string", length=50, unique=true)
     */
    private $email;

    /**
     * @var string
     * Assert\NotBlank()
     * @ORM\Column(name="civilite", type="string", length=3)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_enregistrement", type="datetime")
     */
    private $dateEnregistrement;

    /**
     *
     * @var string
     * @Assert\NotBlank(groups={"registration"})
     */
    private $mdpclair;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="membre")
     */
    private $commande;

    public function __construct() {
        $this->dateEnregistrement = new \DateTime();
        $this->role = 'ROLE_USER';
    }

    /**
     * Get id
     * Assert\NotBlank()
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Membre
     */
    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo() {
        return $this->pseudo;
    }

    /**
     * Set mdp
     *
     * @param string $mdp
     *
     * @return Membre
     */
    public function setMdp($mdp) {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp
     *
     * @return string
     */
    public function getMdp() {
        return $this->mdp;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Membre
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Membre
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Membre
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return Membre
     */
    public function setCivilite($civilite) {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite() {
        return $this->civilite;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Membre
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Set dateEnregistrement
     *
     * @param \DateTime $dateEnregistrement
     *
     * @return Membre
     */
    public function setDateEnregistrement($dateEnregistrement) {
        $this->dateEnregistrement = $dateEnregistrement;

        return $this;
    }

    /**
     * Get dateEnregistrement
     *
     * @return \DateTime
     */
    public function getDateEnregistrement() {
        return $this->dateEnregistrement;
    }

    public function getPassword() {
        return $this->mdp;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return[$this->role];
    }

    public function getSalt() {
        return NULL;
    }

    public function getUsername() {
        return $this->pseudo;
    }

    public function getMdpclair() {
        return $this->mdpclair;
    }

    public function setMdpclair($mdpclair) {
        $this->mdpclair = $mdpclair;
        return $this;
    }

    /**
     * 
     * @return int le nb d'salle de produit
     */
    public function countCommande() {
        return $this->commande->count();
    }

    /**
     * 
     * @return bool 
     */
    public function hasCommande() {
        return $this->countCommande() != 0;
    }

}
