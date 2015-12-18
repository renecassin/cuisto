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
     * @ORM\OneToMany(targetEntity="CommandePlat", mappedBy="Id")
     */
    private $commandeplat;
   /* /**
     * @ORM\ManyToMany(targetEntity="Menu", mappedBy="Commande")
     */
    /**
     * @ORM\OneToMany(targetEntity="CommandeMenu", mappedBy="Id")
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
     * Add commandeplat
     *
     * @param \AvekApeti\BackBundle\Entity\CommandePlat $commandeplat
     *
     * @return Commande
     */
    public function addCommandeplat(\AvekApeti\BackBundle\Entity\CommandePlat $commandeplat)
    {
        $this->commandeplat[] = $commandeplat;

        return $this;
    }

    /**
     * Remove commandeplat
     *
     * @param \AvekApeti\BackBundle\Entity\CommandePlat $commandeplat
     */
    public function removeCommandeplat(\AvekApeti\BackBundle\Entity\CommandePlat $commandeplat)
    {
        $this->commandeplat->removeElement($commandeplat);
    }

    /**
     * Get commandeplat
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandeplat()
    {
        return $this->commandeplat;
    }

    /**
     * Add commandemenu
     *
     * @param \AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu
     *
     * @return Commande
     */
    public function addCommandemenu(\AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu)
    {
        $this->commandemenu[] = $commandemenu;

        return $this;
    }

    /**
     * Remove commandemenu
     *
     * @param \AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu
     */
    public function removeCommandemenu(\AvekApeti\BackBundle\Entity\CommandeMenu $commandemenu)
    {
        $this->commandemenu->removeElement($commandemenu);
    }

    /**
     * Get commandemenu
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandemenu()
    {
        return $this->commandemenu;
    }

    /**
     * Set livraison
     *
     * @param \AvekApeti\BackBundle\Entity\TypeLivraison $livraison
     *
     * @return Commande
     */
    public function setLivraison(\AvekApeti\BackBundle\Entity\TypeLivraison $livraison = null)
    {
        $this->livraison = $livraison;

        return $this;
    }

    /**
     * Get livraison
     *
     * @return \AvekApeti\BackBundle\Entity\TypeLivraison
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     * Set typecommande
     *
     * @param \AvekApeti\BackBundle\Entity\TypeCommande $typecommande
     *
     * @return Commande
     */
    public function setTypecommande(\AvekApeti\BackBundle\Entity\TypeCommande $typecommande = null)
    {
        $this->typecommande = $typecommande;

        return $this;
    }

    /**
     * Get typecommande
     *
     * @return \AvekApeti\BackBundle\Entity\TypeCommande
     */
    public function getTypecommande()
    {
        return $this->typecommande;
    }
}
