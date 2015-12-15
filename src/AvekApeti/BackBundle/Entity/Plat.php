<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PLat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\PlatRepository")
 */
class Plat
{
    public function __construct()
    {
        $this->tlivs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->avis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCreated = new \DateTime("now");

    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="unableWhile", type="datetime")
     */
    private $unableWhile;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     */
    private $Utilisateur;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Specialite")
     */
    private $specialite;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     */
    private $categorie;
    /**
     * @ORM\ManyToMany(targetEntity="TypeLivraison", inversedBy="Plat" )
     * @ORM\JoinTable(name="plat_typelivraison",
     *    joinColumns={
     *				@ORM\JoinColumn(name="plat_id", referencedColumnName="id")
     *		},
     *		inverseJoinColumns={
     *       @ORM\JoinColumn(name="typelivraison_id", referencedColumnName="id")
     *   }
     *)
     */
    public $tlivs;
    /**
     * @ORM\ManyToMany(targetEntity="TypeCommande", inversedBy="Plat" )
     * @ORM\JoinTable(name="plat_typecommande",
     *    joinColumns={
     *				@ORM\JoinColumn(name="plat_id", referencedColumnName="id")
     *		},
     *		inverseJoinColumns={
     *       @ORM\JoinColumn(name="typecommande_id", referencedColumnName="id")
     *   }
     *)
     */
    public $tcoms;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     */
    private $image;
    /**
     * @ORM\OneToMany(targetEntity="Avis", mappedBy="platAvis", cascade={"remove"})
     */
    private $avis;
 /*   /**
     * @ORM\ManyToMany(targetEntity="Commande", inversedBy="Plat" )
     * @ORM\JoinTable(name="commande_plat",
     *    joinColumns={
     *				@ORM\JoinColumn(name="plat_id", referencedColumnName="id")
     *		},
     *		inverseJoinColumns={
     *       @ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     *   }
     *)
     */
    /**
     * @ORM\ManyToOne(targetEntity="CommandePlat")
     */
    private $commande;
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Plat
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Plat
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Plat
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Plat
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Plat
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unableWhile
     *
     * @param \DateTime $unableWhile
     *
     * @return Plat
     */
    public function setUnableWhile($unableWhile)
    {
        $this->unableWhile = $unableWhile;

        return $this;
    }

    /**
     * Get unableWhile
     *
     * @return \DateTime
     */
    public function getUnableWhile()
    {
        return $this->unableWhile;
    }
    /**
     * Constructor
     */


    /**
     * Set utilisateur
     *
     * @param \AvekApeti\BackBundle\Entity\Utilisateur $utilisateur
     *
     * @return Plat
     */
    public function setUtilisateur(\AvekApeti\BackBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->Utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AvekApeti\BackBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->Utilisateur;
    }

    /**
     * Set specialite
     *
     * @param \AvekApeti\BackBundle\Entity\Specialite $specialite
     *
     * @return Plat
     */
    public function setSpecialite(\AvekApeti\BackBundle\Entity\Specialite $specialite = null)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return \AvekApeti\BackBundle\Entity\Specialite
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set categorie
     *
     * @param \AvekApeti\BackBundle\Entity\Categorie $categorie
     *
     * @return Plat
     */
    public function setCategorie(\AvekApeti\BackBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AvekApeti\BackBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Add tliv
     *
     * @param \AvekApeti\BackBundle\Entity\TypeLivraison $tliv
     *
     * @return Plat
     */
    public function addTliv(\AvekApeti\BackBundle\Entity\TypeLivraison $tliv)
    {
        $this->tlivs[] = $tliv;

        return $this;
    }

    /**
     * Remove tliv
     *
     * @param \AvekApeti\BackBundle\Entity\TypeLivraison $tliv
     */
    public function removeTliv(\AvekApeti\BackBundle\Entity\TypeLivraison $tliv)
    {
        $this->tlivs->removeElement($tliv);
    }

    /**
     * Get tlivs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTlivs()
    {
        return $this->tlivs;
    }

    /**
     * Add avi
     *
     * @param \AvekApeti\BackBundle\Entity\Avis $avi
     *
     * @return Plat
     */
    public function addAvi(\AvekApeti\BackBundle\Entity\Avis $avi)
    {
        $this->avis[] = $avi;

        return $this;
    }

    /**
     * Remove avi
     *
     * @param \AvekApeti\BackBundle\Entity\Avis $avi
     */
    public function removeAvi(\AvekApeti\BackBundle\Entity\Avis $avi)
    {
        $this->avis->removeElement($avi);
    }

    /**
     * Get avis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * Set image
     *
     * @param \AvekApeti\BackBundle\Entity\Image $image
     *
     * @return Plat
     */
    public function setImage(\AvekApeti\BackBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AvekApeti\BackBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Plat
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return \boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add commande
     *
     * @param \AvekApeti\BackBundle\Entity\Commande $commande
     *
     * @return Plat
     */
    public function addCommande(\AvekApeti\BackBundle\Entity\Commande $commande)
    {
        $this->commande[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \AvekApeti\BackBundle\Entity\Commande $commande
     */
    public function removeCommande(\AvekApeti\BackBundle\Entity\Commande $commande)
    {
        $this->commande->removeElement($commande);
    }

    /**
     * Get commande
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Add tcom
     *
     * @param \AvekApeti\BackBundle\Entity\TypeCommande $tcom
     *
     * @return Plat
     */
    public function addTcom(\AvekApeti\BackBundle\Entity\TypeCommande $tcom)
    {
        $this->tcoms[] = $tcom;

        return $this;
    }

    /**
     * Remove tcom
     *
     * @param \AvekApeti\BackBundle\Entity\TypeCommande $tcom
     */
    public function removeTcom(\AvekApeti\BackBundle\Entity\TypeCommande $tcom)
    {
        $this->tcoms->removeElement($tcom);
    }

    /**
     * Get tcoms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTcoms()
    {
        return $this->tcoms;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return Plat
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Plat
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set commande
     *
     * @param \AvekApeti\BackBundle\Entity\CommandePlat $commande
     *
     * @return Plat
     */
    public function setCommande(\AvekApeti\BackBundle\Entity\CommandePlat $commande = null)
    {
        $this->commande = $commande;

        return $this;
    }
}
