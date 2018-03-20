<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="Produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Salle
     * @ORM\ManyToOne(targetEntity="Salle",fetch="EAGER",inversedBy="produit")
     * @ORM\JoinColumn(name="salle_id", referencedColumnName="id", nullable=false)
     */
    private $salle;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_arrivee", type="date")
     */
    private $dateArrivee;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_depart", type="date")
     */
    private $dateDepart;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="produit")
     */
    private $commande;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param Salle 
     *
     * @return Salle
     */
    public function setSalle(Salle $salle) {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Get idSalle
     *
     * @return int
     */
    public function getSalle() {
        return $this->salle;
    }

    /**
     * Set dateArrivee
     *
     * @param \DateTime $dateArrivee
     *
     * @return Produit
     */
    public function setDateArrivee($dateArrivee) {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }

    /**
     * Get dateArrivee
     *
     * @return \DateTime
     */
    public function getDateArrivee() {
        return $this->dateArrivee;
    }

    /**
     * Set dateDepart
     *
     * @param \DateTime $dateDepart
     *
     * @return Produit
     */
    public function setDateDepart($dateDepart) {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    /**
     * Get dateDepart
     *
     * @return \DateTime
     */
    public function getDateDepart() {
        return $this->dateDepart;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Produit
     */
    public function setPrix($prix) {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix() {
        return $this->prix;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Produit
     */
    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat() {
        return $this->etat;
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
