<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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
        $this->commandeplat = new ArrayCollection();
        $this->commandemenu = new ArrayCollection();

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
    private $utilisateur;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Chef")
     */
    private $chef;
    /*/**
     * @ORM\ManyToMany(targetEntity="Plat", mappedBy="Commande")
     */
    /**
     * @ORM\ManyToOne(targetEntity="CommandePlat")
     */
    private $commandeplat;
   /* /**
     * @ORM\ManyToMany(targetEntity="Menu", mappedBy="Commande")
     */
    /**
     * @ORM\ManyToOne(targetEntity="CommandeMenu")
     */
    private $commandemenu;
    /**
     * @ORM\ManyToOne(targetEntity="TypeLivraison")
     */
    private $livraison;

    /**
     * @ORM\ManyToOne(targetEntity="TypeCommande")
     */
    private $typecommande;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    /**
     * @var string
     *
     * @ORM\Column(name="content_validation", type="text",nullable=true)
     */
    private $content_validation;
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
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AvekApeti\BackBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
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
        $this->chef = $chef;

        return $this;
    }

    /**
     * Get chef
     *
     * @return \AvekApeti\BackBundle\Entity\Chef
     */
    public function getChef()
    {
        return $this->chef;
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

    /**
     * Set contentValidation
     *
     * @param string $contentValidation
     *
     * @return Commande
     */
    public function setContentValidation($contentValidation)
    {
        $this->content_validation = $contentValidation;

        return $this;
    }

    /**
     * Get contentValidation
     *
     * @return string
     */
    public function getContentValidation()
    {
        return $this->content_validation;
    }
    /**
     * Add commandeplat
     *
     * @param \AvekApeti\BackBundle\Entity\CommandePlat $commandeplat
     * @return Plat
     */
    public function addCommandeplat(\AvekApeti\BackBundle\Entity\CommandePlat $commandeplat)
    {

            $commandeplat->setCommande($this);
           // $this->$commandeplat[] = $commandeplat;
        array_push($this->$commandeplat,$commandeplat);
        return $this;
    }
    /**
     * Remove commandeplat
     *
     * @param \AvekApeti\BackBundle\Entity\CommandePlat $commandeplat
     */
    public function removeUsercoupon(\AvekApeti\BackBundle\Entity\CommandePlat $commandeplat)
    {
        $this->$commandeplat->removeElement($commandeplat);
       // $this->oldCoupons[] = $usercoupon;
    }
    /**
     * Add commandemenu
     *
     * @param \AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu
     * @return Plat
     */
    public function addCommandemenu(\AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu)
    {

        $commandemenu->setCommande($this);
       // $this->$commandemenu[] = $commandemenu;
        array_push($this->$commandemenu,$commandemenu);

        return $this;
    }
    /**
     * Remove commandemenu
     *
     * @param \AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu
     */
    public function removeCommandeMenu(\AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu)
    {
        $this->$commandemenu->removeElement($commandemenu);
        // $this->oldCoupons[] = $usercoupon;
    }

    /**
     * Set commandeplat
     *
     * @param \AvekApeti\BackBundle\Entity\CommandePlat $commandeplat
     *
     * @return Commande
     */
    public function setCommandeplat(\AvekApeti\BackBundle\Entity\CommandePlat $commandeplat = null)
    {
        $this->commandeplat = $commandeplat;

        return $this;
    }

    /**
     * Get commandeplat
     *
     * @return \AvekApeti\BackBundle\Entity\CommandePlat
     */
    public function getCommandeplat()
    {
        return $this->commandeplat;
    }

    /**
     * Set commandemenu
     *
     * @param \AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu
     *
     * @return Commande
     */
    public function setCommandemenu(\AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu = null)
    {
        $this->commandemenu = $commandemenu;

        return $this;
    }

    /**
     * Get commandemenu
     *
     * @return \AvekApeti\BackBundle\Entity\CommandeMenu
     */
    public function getCommandemenu()
    {
        return $this->commandemenu;
    }
}
