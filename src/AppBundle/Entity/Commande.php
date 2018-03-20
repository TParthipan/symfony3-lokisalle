<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 */
class Commande {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_enregistrement", type="datetime")
     */
    private $dateEnregistrement;

    /**
     * @var Produit
     * @ORM\ManyToOne(targetEntity="Produit",fetch="EAGER",inversedBy="commande")
     * @ORM\JoinColumn(name="produit_id", referencedColumnName="id", nullable=false)
     */
    private $produit;

    /**
     * @var Membre
     * @ORM\ManyToOne(targetEntity="Membre",fetch="EAGER", inversedBy="commande")
     * @ORM\JoinColumn(name="membre_id", referencedColumnName="id", nullable=false)
     */
    private $membre;

    public function __construct() {
        $this->dateEnregistrement = new \DateTime();
    }

    /**
     * Get id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dateEnregistrement
     *
     * @param \DateTime $dateEnregistrement
     *
     * @return Commande
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

    public function getProduit() {
        return $this->produit;
    }

    public function getMembre() {
        return $this->membre;
    }

    public function setProduit(Produit $produit) {
        $this->produit = $produit;
        return $this;
    }

    public function setMembre(Membre $membre) {
        $this->membre = $membre;
        return $this;
    }

}
