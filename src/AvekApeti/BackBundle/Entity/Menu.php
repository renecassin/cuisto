<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\MenuRepository")
 */
class Menu
{
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
     * @ORM\ManyToMany(targetEntity="Plat", inversedBy="menu" )
     * @ORM\JoinTable(name="menu_plat",
     *    joinColumns={
     *				@ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     *		},
     *		inverseJoinColumns={
     *       @ORM\JoinColumn(name="plat_id", referencedColumnName="id")
     *   }
     *)
     */
    private $plats;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     */
    private $Utilisateur;
    /**
     * @ORM\ManyToMany(targetEntity="TypeLivraison", inversedBy="menu" )
     * @ORM\JoinTable(name="menu_typelivraison",
     *    joinColumns={
     *				@ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     *		},
     *		inverseJoinColumns={
     *       @ORM\JoinColumn(name="typelivraison_id", referencedColumnName="id")
     *   }
     *)
     */
    private $tlivs;

    /**
     * @ORM\ManyToOne(targetEntity="CommandeMenu")
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
     * @return Menu
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
     * @return Menu
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
     * Constructor
     */
    public function __construct()
    {
        $this->plats = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tlivs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add plat
     *
     * @param \AvekApeti\BackBundle\Entity\Plat $plat
     *
     * @return Menu
     */
    public function addPlat(\AvekApeti\BackBundle\Entity\Plat $plat)
    {
        $this->plats[] = $plat;

        return $this;
    }

    /**
     * Remove plat
     *
     * @param \AvekApeti\BackBundle\Entity\Plat $plat
     */
    public function removePlat(\AvekApeti\BackBundle\Entity\Plat $plat)
    {
        $this->plats->removeElement($plat);
    }

    /**
     * Get plats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlats()
    {
        return $this->plats;
    }

    /**
     * Set utilisateur
     *
     * @param \AvekApeti\BackBundle\Entity\Utilisateur $utilisateur
     *
     * @return Menu
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
     * Add tliv
     *
     * @param \AvekApeti\BackBundle\Entity\TypeLivraison $tliv
     *
     * @return Menu
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
     * Add commande
     *
     * @param \AvekApeti\BackBundle\Entity\Commande $commande
     *
     * @return Menu
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
}
