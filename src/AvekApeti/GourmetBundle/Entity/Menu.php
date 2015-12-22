<?php

namespace AvekApeti\GourmetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class MenuPanier
{

    private $menu;

    private $quantity;

    public $tliv;

    public $tcoms;


    public function setMenu(\AvekApeti\BackBundle\Entity\Menu $menu)
    {
        $this->menu = $menu;

        return $this;
    }

    public function getMenu()
    {
        return $this->menu;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setTliv(\AvekApeti\BackBundle\Entity\TypeLivraison $tliv = null)
    {
        $this->tliv = $tliv;

        return $this;
    }

    public function getTliv()
    {
        return $this->tliv;
    }

    public function setTcoms(\AvekApeti\BackBundle\Entity\TypeCommande $tcoms = null)
    {
        $this->tcoms = $tcoms;

        return $this;
    }

    public function getTcoms()
    {
        return $this->tcoms;
    }
}
