<?php

namespace AvekApeti\GourmetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Panier
{

    public function __construct()
    {
        $tableauPlats = [];
        $tableauMenus = [];


    }

    private $id ;

    private $chefSelect;

    private $tableauPlats;

    private $tableauMenus;
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    public function getChefSelect(){
        return $this->chefSelect;

    }
    public function getTableauPlats(){
        return $this->tableauPlats;
    }
    public function getTableauMenus(){
        return $this->tableauMenus;
    }
    public function addTableauPlats(\AvekApeti\GourmetBundle\Entity\PlatPanier $PlatPanier){
        $this->tableauPlats[] = $PlatPanier;
        return $this;
    }
    public function addTableauMenus(\AvekApeti\GourmetBundle\Entity\MenuPanier $MenuPanier){
        $this->tableauMenus[] = $MenuPanier;
        return $this;
    }

}

