<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandePlat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\CommandePlatRepository")
 */
class CommandePlat
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
     * @var integer
     * @ORM\OneToMany(targetEntity="Plat")
     * @ORM\Column(name="platId", type="integer")
     */
    private $platId;

    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="Commande")
     * @ORM\Column(name="commandeId", type="integer")
     */
    private $commandeId;

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
     * Set platId
     *
     * @param integer $platId
     *
     * @return CommandePlat
     */
    public function setPlatId($platId)
    {
        $this->platId = $platId;

        return $this;
    }

    /**
     * Get platId
     *
     * @return integer
     */
    public function getPlatId()
    {
        return $this->platId;
    }

    /**
     * Set commandeId
     *
     * @param integer $commandeId
     *
     * @return CommandePlat
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
     * @return CommandePlat
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
}

