<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\CommandeRepository")
 */
class Commande
{
    public function __construct()
    {
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     */
    private $Utilisateur;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Chef")
     */
    private $Chef;
    /*/**
     * @ORM\ManyToMany(targetEntity="Plat", mappedBy="Commande")
     */
    /**
     * @ORM\ManyToMany(targetEntity="Plat", inversedBy="Commande" )
     * @ORM\JoinTable(name="commande_plat",
     *    joinColumns={
     *				@ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     *		},
     *		inverseJoinColumns={
     *       @ORM\JoinColumn(name="plat_id", referencedColumnName="id")
     *   }
     *)
     */
    private $plat;
   /* /**
     * @ORM\ManyToMany(targetEntity="Menu", mappedBy="Commande")
     */
    /**
     * @ORM\ManyToMany(targetEntity="Menu", inversedBy="Commande" )
     * @ORM\JoinTable(name="commande_menu",
     *    joinColumns={
     *				@ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     *		},
     *		inverseJoinColumns={
     *       @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     *   }
     *)
     */
    private $menu;
    /**
     * @ORM\ManyToOne(targetEntity="TypeLivraison")
     */
    private $livraison;
    /**
     * @var string
     *
     * @ORM\Column(name="typecommande", type="string", length=255)
     */
    private $typecommande;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Commande
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
     * Set total
     *
     * @param float $total
     *
     * @return Commande
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Commande
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set utilisateur
     *
     * @param \AvekApeti\BackBundle\Entity\Utilisateur $utilisateur
     *
     * @return Commande
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
     * Set chef
     *
     * @param \AvekApeti\BackBundle\Entity\Chef $chef
     *
     * @return Commande
     */
    public function setChef(\AvekApeti\BackBundle\Entity\Chef $chef = null)
    {
        $this->Chef = $chef;

        return $this;
    }

    /**
     * Get chef
     *
     * @return \AvekApeti\BackBundle\Entity\Chef
     */
    public function getChef()
    {
        return $this->Chef;
    }

    /**
     * Set livraison
     *
     * @param string $livraison
     *
     * @return Commande
     */
    public function setLivraison($livraison)
    {
        $this->livraison = $livraison;

        return $this;
    }

    /**
     * Get livraison
     *
     * @return string
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     * Set typecommande
     *
     * @param string $typecommande
     *
     * @return Commande
     */
    public function setTypecommande($typecommande)
    {
        $this->typecommande = $typecommande;

        return $this;
    }

    /**
     * Get typecommande
     *
     * @return string
     */
    public function getTypecommande()
    {
        return $this->typecommande;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Commande
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
     * Add plat
     *
     * @param \AvekApeti\BackBundle\Entity\Plat $plat
     *
     * @return Commande
     */
    public function addPlat(\AvekApeti\BackBundle\Entity\Plat $plat)
    {
        $this->plat[] = $plat;

        return $this;
    }

    /**
     * Remove plat
     *
     * @param \AvekApeti\BackBundle\Entity\Plat $plat
     */
    public function removePlat(\AvekApeti\BackBundle\Entity\Plat $plat)
    {
        $this->plat->removeElement($plat);
    }

    /**
     * Get plat
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlat()
    {
        return $this->plat;
    }

    /**
     * Add menu
     *
     * @param \AvekApeti\BackBundle\Entity\Menu $menu
     *
     * @return Commande
     */
    public function addMenu(\AvekApeti\BackBundle\Entity\Menu $menu)
    {
        $this->menu[] = $menu;

        return $this;
    }

    /**
     * Remove menu
     *
     * @param \AvekApeti\BackBundle\Entity\Menu $menu
     */
    public function removeMenu(\AvekApeti\BackBundle\Entity\Menu $menu)
    {
        $this->menu->removeElement($menu);
    }

    /**
     * Get menu
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
