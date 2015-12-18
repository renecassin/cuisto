<?php

namespace GourmetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Menu
{

    private $id;

    private $name;

    private $plats;

    private $UtilisateurId;

    private $tlivs;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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

    /**
     * Add commandeMenu
     *
     * @param \AvekApeti\BackBundle\Entity\CommandeMenu $commandeMenu
     *
     * @return Menu
     */
    public function addCommandeMenu(\AvekApeti\BackBundle\Entity\CommandeMenu $commandeMenu)
    {
        $this->commandeMenu[] = $commandeMenu;

        return $this;
    }

    /**
     * Remove commandeMenu
     *
     * @param \AvekApeti\BackBundle\Entity\CommandeMenu $commandeMenu
     */
    public function removeCommandeMenu(\AvekApeti\BackBundle\Entity\CommandeMenu $commandeMenu)
    {
        $this->commandeMenu->removeElement($commandeMenu);
    }

    /**
     * Get commandeMenu
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandeMenu()
    {
        return $this->commandeMenu;
    }
}
