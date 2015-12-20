<?php

namespace AvekApeti\GourmetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Panier
{

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
    public function setTableauPlats($Plat){
        array_push ($this->tableauPlats, $Plat);
        return $this;
    }
    public function setTableauMenus($Menu){
        array_push ($this->tableauMenus, $Menu);
        return $this;
    }
}

