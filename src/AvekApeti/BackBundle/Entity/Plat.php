<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PLat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\PlatRepository")
 * @ORM\HasLifecycleCallbacks()
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
     *
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     *
     * )
     */
    private $content;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="price_net", type="float")
     */
    private $priceNet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     *
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
     * @ORM\ManyToOne(targetEntity="TypeLivraison")
     */
    public $tliv;
    /**
     * @ORM\ManyToOne(targetEntity="TypeCommande")
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
     * @ORM\OneToMany(targetEntity="CommandePlat", mappedBy="plats_id")
     */
    private $commandePlat;
    /**
     * @var integer
     *
     * @ORM\Column(name="supp", type="boolean", nullable=true)
     */
    private $supp;

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
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
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
     * Set tliv
     *
     * @param \AvekApeti\BackBundle\Entity\TypeLivraison $tliv
     *
     * @return Plat
     */
    public function setTliv(\AvekApeti\BackBundle\Entity\TypeLivraison $tliv = null)
    {
        $this->tliv = $tliv;

        return $this;
    }

    /**
     * Get tliv
     *
     * @return \AvekApeti\BackBundle\Entity\TypeLivraison
     */
    public function getTliv()
    {
        return $this->tliv;
    }

    /**
     * Set tcoms
     *
     * @param \AvekApeti\BackBundle\Entity\TypeCommande $tcoms
     *
     * @return Plat
     */
    public function setTcoms(\AvekApeti\BackBundle\Entity\TypeCommande $tcoms = null)
    {
        $this->tcoms = $tcoms;

        return $this;
    }

    /**
     * Get tcoms
     *
     * @return \AvekApeti\BackBundle\Entity\TypeCommande
     */
    public function getTcoms()
    {
        return $this->tcoms;
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
     * Add commandePlat
     *
     * @param \AvekApeti\BackBundle\Entity\CommandePlat $commandePlat
     *
     * @return Plat
     */
    public function addCommandePlat(\AvekApeti\BackBundle\Entity\CommandePlat $commandePlat)
    {
        $this->commandePlat[] = $commandePlat;

        return $this;
    }

    /**
     * Remove commandePlat
     *
     * @param \AvekApeti\BackBundle\Entity\CommandePlat $commandePlat
     */
    public function removeCommandePlat(\AvekApeti\BackBundle\Entity\CommandePlat $commandePlat)
    {
        $this->commandePlat->removeElement($commandePlat);
    }

    /**
     * Get commandePlat
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandePlat()
    {
        return $this->commandePlat;
    }

    /**
     * Set delete
     *
     * @param boolean $delete
     *
     * @return Plat
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;

        return $this;
    }

    /**
     * Get delete
     *
     * @return boolean
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Set supp
     *
     * @param boolean $supp
     *
     * @return Plat
     */
    public function setSupp($supp)
    {
        $this->supp = $supp;

        return $this;
    }

    /**
     * Get supp
     *
     * @return boolean
     */
    public function getSupp()
    {
        return $this->supp;
    }

    /**
     * @return float
     */
    public function getPriceNet()
    {
        return $this->priceNet;
    }

    /**
     * @param float $priceNet
     */
    public function setPriceNet($priceNet)
    {
        $this->priceNet = $priceNet;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function calculPriceNet()
    {
        $this->priceNet = $this->price * 1.12;
    }


}
