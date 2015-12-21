<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PanierController extends Controller
{
    public function indexAction()
    {
        return $this->render('GourmetBundle:Panier:index.html.twig', array(
                // ...
            ));
    }
    public function ajoutPanierAction($idPlat)
    {
        //Si l'id du chef est different que ceux enregistrer refuser l'ajout

        return $this->render('GourmetBundle:Panier:index.html.twig', array(
            // ...
        ));
    }
    public function suppPanierAction($idPlat)
    {
        return $this->render('GourmetBundle:Panier:index.html.twig', array(
            // ...
        ));
    }
    public function resetPanierAction()
    {
        return $this->render('GourmetBundle:Panier:index.html.twig', array(
            // ...
        ));
    }

}
