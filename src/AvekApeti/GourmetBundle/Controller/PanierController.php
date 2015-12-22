<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GourmetBundle\Entity\Plat;
use GourmetBundle\Entity\Menu;
use GourmetBundle\Entity\Panier;

class PanierController extends Controller
{
    public function indexAction()
    {
        $Panier = false;
            if(ISSET($_SESSION['Panier']))
            {
                $Panier = $_SESSION['Panier'];
            }
        return $this->render('GourmetBundle:Panier:index.html.twig', array(
                'panier' => $Panier
            ));
    }

    public function ajoutPlatPanierAction($idPlat)
    {
        if($idPlat)
            return Redirection_origine();

        $em = $this->getDoctrine()->getManager();
        $Plat = $em->getRepository('AvekApetiBackBundle:Plat')->find($idPlat);
        $Panier = $_SESSION['Panier'];
        if($Panier)
        {
            if($Panier->getChefSelect()->getUtilisateur() == $Plat->getUtilisateur())
            {
                platExiste($Plat,$Panier->getTableauPlats());

            }else
            {
                //L'utilisateur commande des plats de different chef
                //Different message d'erreur en fonction
                return Redirection_origine();
            }

        }else{
            $Panier = new Panier;
            $platPanier = new PlatPanier;
            $platPanier->setPlat($Plat);
            $platPanier->setQuantity('1');
            $platPanier->setTliv($Plat->getTliv());
            $platPanier->setTcoms($Plat->getTcoms());

            $Panier->addTableauPlats($platPanier);

        }

         $_SESSION['Panier']=$Panier;

        $url = $this->container->get('request')->headers->get('referer');
        if(empty($url)) {
            $url = $this->container->get('router')->generate('myapp_accueil');
        }
        return Redirection_origine();

    }
    public function suppPlatPanierAction($idPlat)
    {
        if($idPlat)
            return Redirection_origine();

        $em = $this->getDoctrine()->getManager();
        $Plat = $em->getRepository('AvekApetiBackBundle:Plat')->find($idPlat);
        $Panier = $_SESSION['Panier'];
        if($Panier)
        {
            platSuppr($Plat,$Panier->getTableauPlats());

        }else
        {
            //L'utilisateur commande des plats de different chef
            //Different message d'erreur en fonction
            return Redirection_origine();
        }
        return Redirection_origine();
    }
    public function resetPanierAction()
    {
        $_SESSION['Panier']='';
        return Redirection_origine();
    }

    private function platExiste($Plat,$tableauPlat)
    {
        foreach ($tableauPlat as $platPanier){
            if($platPanier->getPlat() == $Plat){
                $platPanier->setQuantity($platPanier->getQuantity()+1);
                return true;
            }
        }
        $platPanier = new PlatPanier;
        $platPanier->setPlat();
        $platPanier->setQuantity();
        $platPanier->setTliv();
        $platPanier->setTcoms();

        $tableauPlat->addTableauPlats($platPanier);
        return false;
    }
    private function  platSuppr($Plat,$tableauPlat)
    {
        foreach ($tableauPlat as $platPanier){
            if($platPanier->getPlat() == $Plat) {
                if ($platPanier->getQuantity() > 1) {
                $platPanier->setQuantity($platPanier->getQuantity() - 1);
                 }else
                {
                    array_splice($tableauPlat, 0,1);
                }
            }
        }
    }
    private function Redirection_origine()
    {
        $url = $this->container->get('request')->headers->get('referer');
        if(empty($url)) {
            $url = $this->container->get('router')->generate('gourmet_homepage');
        }
        return new RedirectResponse($url);
    }

}
