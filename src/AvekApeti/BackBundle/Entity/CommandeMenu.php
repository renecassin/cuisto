<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandeMenu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\CommandeMenuRepository")
 */
class CommandeMenu
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
     * @ORM\ManyToOne(targetEntity="Menu")
     * @ORM\JoinColumn(nullable=true)
     */
    private $menus;

    /**
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;


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
     * Set menuId
     *
     * @param integer $menuId
     *
     * @return CommandeMenu
     */
    public function setMenuId($menuId)
    {
        $this->menuId = $menuId;

        return $this;
    }

    /**
     * Get menuId
     *
     * @return integer
     */
    public function getMenuId()
    {
        return $this->menuId;
    }

    /**
     * Set commandeId
     *
     * @param integer $commandeId
     *
     * @return CommandeMenu
     */
    public function setCommandeId($commandeId)
    {
        $this->commandeId = $commandeId;

        return $this;
    }

    /**
     * Get commandeId
     *
     * @return integer
     */
    public function getCommandeId()
    {
        return $this->commandeId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CommandeMenu
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
     * Set menus
     *
     * @param \AvekApeti\BackBundle\Entity\Menu $menus
     *
     * @return CommandeMenu
     */
    public function setMenus(\AvekApeti\BackBundle\Entity\Menu $menus = null)
    {
        $this->menus = $menus;

        return $this;
    }

    /**
     * Get menus
     *
     * @return \AvekApeti\BackBundle\Entity\Menu
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Set commande
     *
     * @param \AvekApeti\BackBundle\Entity\Commande $commande
     *
     * @return CommandeMenu
     */
    public function setCommande(\AvekApeti\BackBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \AvekApeti\BackBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
