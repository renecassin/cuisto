<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AvekApeti\GourmetBundle\Entity\PlatPanier;
use AvekApeti\GourmetBundle\Entity\Menu;
use AvekApeti\GourmetBundle\Entity\Panier;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function indexAction(Request $request)
    {
        //$session = $request->getSession();

      //  die(dump($session->get('Panier')));
        $Panier = false;
            if($this->getUser()->hasAttribute('Panier',$request))
            {

                $Panier = $this->getUser()->getAttribute('Panier',$request);
            }

        return $this->render('GourmetBundle:Panier:index.html.twig', array(
                'panier' => $Panier
            ));
    }

    public function ajoutPlatPanierAction($idPlat, Request $request)
    {


        if($idPlat == null)
            return $this->Redirection_origine();

        $em = $this->getDoctrine()->getManager();
        $Plat = $em->getRepository('AvekApetiBackBundle:Plat')->find($idPlat);
        $Panier = $this->getUser()->getAttribute('Panier',$request);
        if($this->getUser()->hasAttribute('Panier',$request))
        {

            if($Panier->getChefSelect()->getId() == $Plat->getUtilisateur()->getId())
            {

                $this->platExiste($Plat,$Panier);
                $this->getUser()->setAttribute('Panier',$Panier,$request);

            }else
            {

                //L'utilisateur commande des plats de different chef
                //Different message d'erreur en fonction

            }
            return $this->Redirection_origine();
        }else{



            $Panier = new Panier;
            $platPanier = new PlatPanier;
            $platPanier->setPlat($Plat);
            $platPanier->setQuantity('1');
            $platPanier->setTliv($Plat->getTliv());
            $platPanier->setTcoms($Plat->getTcoms());

            $Panier->addTableauPlats($platPanier);
            $Panier->setChefSelect($Plat->getUtilisateur());
        }

         //$_SESSION['Panier']=$Panier;
        $this->getUser()->setAttribute('Panier',$Panier,$request);

        //$session = $request->getSession();
        //$session->set('Panier', $Panier);

        return $this->Redirection_origine();

    }
    public function suppPlatPanierAction($idPlat,Request $request)
    {


        if($idPlat == null)
            return $this->Redirection_origine();

        $em = $this->getDoctrine()->getManager();
        $Plat = $em->getRepository('AvekApetiBackBundle:Plat')->find($idPlat);
        $Panier =  $this->getUser()->getAttribute('Panier',$request);
        if($Panier)
        {
            $this->platSuppr($Plat,$Panier);
            $this->getUser()->setAttribute('Panier',$Panier,$request);

        }else
        {
            //L'utilisateur commande des plats de different chef
            //Different message d'erreur en fonction
            return $this->Redirection_origine();
        }
        return $this->Redirection_origine();
    }
    public function resetPanierAction(Request $request)
    {

        $this->getUser()->resetAttribute('Panier',$request);
        return $this->Redirection_origine();
    }

    private function platExiste($Plat,$Panier)
    {
        $tableauPlat = $Panier->getTableauPlats();
        foreach ($tableauPlat as $platPanier){
            if($platPanier->getPlat()->getId() == $Plat->getId()){

                $platPanier->setQuantity($platPanier->getQuantity()+1);
                return true;
            }
        }
        $platPanier = new PlatPanier;
        $platPanier->setPlat($Plat);
        $platPanier->setQuantity(1);
        $platPanier->setTliv();
        $platPanier->setTcoms();

        $Panier->addTableauPlats($platPanier);
        return false;
    }
    private function  platSuppr($Plat,$Panier)
    {
        $tableauPlat = $Panier->getTableauPlats();
        foreach ($tableauPlat as $platPanier){
            if($platPanier->getPlat()->getId() == $Plat->getId()) {
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
        $referer = $this->getRequest()->headers->get('referer');
        if(empty($referer)) {
            $referer = $this->container->get('router')->generate('gourmet_homepage');
        }
        //Referer ne fonctionne pas avec une adresse entrer a la main ou externe au site
        return new RedirectResponse($referer);
    }

}
