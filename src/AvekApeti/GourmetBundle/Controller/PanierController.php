<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AvekApeti\GourmetBundle\Entity\PlatPanier;
use AvekApeti\GourmetBundle\Entity\MenuPanier;
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
                $this->addFlash(
                    'addPanierOtherChef',
                    true
                );
            }

        }else{



            $Panier = new Panier;
            $platPanier = new PlatPanier;
            $platPanier->setPlat($Plat);
            $platPanier->setQuantity('1');
            $platPanier->setTliv($Plat->getTliv());
            $platPanier->setTcoms($Plat->getTcoms());

            $Panier->addTableauPlats($platPanier);
            $Panier->addTableauPlatsTotal($Plat->getPriceNet());
            $Panier->setChefSelect($Plat->getUtilisateur()->getChef());
        }

         //$_SESSION['Panier']=$Panier;
        $this->getUser()->setAttribute('Panier',$Panier,$request);

        //$session = $request->getSession();
        //$session->set('Panier', $Panier);

        $this->addFlash(
            'addPanier',
            true
        );

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
            $Panier = $this->platSuppr($Plat,$Panier);
            $this->getUser()->setAttribute('Panier',$Panier,$request);

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
        $Panier->addTableauPlatsTotal($Plat->getPriceNet());

        $tableauPlat = $Panier->getTableauPlats();
        if (count($tableauPlat) != 0) {
            foreach ($tableauPlat as $platPanier) {
                if ($platPanier->getPlat()->getId() == $Plat->getId()) {

                    $platPanier->setQuantity($platPanier->getQuantity() + 1);
                    return true;
                }
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
        $c = 0;
        if ($tableauPlat) {
            foreach ($tableauPlat as $platPanier) {
                if ($platPanier->getPlat()->getId() == $Plat->getId()) {
                    if ($platPanier->getQuantity() > 1) {
                        $platPanier->setQuantity($platPanier->getQuantity() - 1);
                    } else {

                        // array_splice($tableauPlat, $c,1);
                        $Panier->supTableauPlats($c);
                    }
                    $Panier->supTableauPlatsTotal($Plat->getPriceNet());
                }
                $c++;
            }
        }
        if ($c == 0)
        {
            $Panier->setTableauPlatsTotal(0);
        }


        return $Panier;
    }
    private function Redirection_origine()
    {
        $referer = $this->getRequest()->headers->get('referer');
        if(empty($referer)) {
            $referer = $this->container->get('router')->generate('panier_index');
        }
        //Referer ne fonctionne pas avec une adresse entrer a la main ou externe au site
        return new RedirectResponse($referer);
    }
    public function ajoutMenuPanierAction($idMenu, Request $request)
    {


        if($idMenu == null)
            return $this->Redirection_origine();

        $em = $this->getDoctrine()->getManager();
        $Menu = $em->getRepository('AvekApetiBackBundle:Menu')->find($idMenu);
        $Panier = $this->getUser()->getAttribute('Panier',$request);
        if($this->getUser()->hasAttribute('Panier',$request))
        {

            if($Panier->getChefSelect()->getId() == $Menu->getUtilisateur()->getId())
            {

                $this->menuExiste($Menu,$Panier);
                $this->getUser()->setAttribute('Panier',$Panier,$request);

            }else
            {

                //L'utilisateur commande des plats de different chef
                //Different message d'erreur en fonction

            }
            return $this->Redirection_origine();
        }else{



            $Panier = new Panier;
            $menuPanier = new PlatPanier;
            $menuPanier->setPlat($Menu);
            $menuPanier->setQuantity('1');
            $menuPanier->setTliv($Menu->getTliv());
            $menuPanier->setTcoms($Menu->getTcoms());

            $Panier->addTableauPlats($menuPanier);
            $Panier->setChefSelect($Menu->getUtilisateur());
        }

        //$_SESSION['Panier']=$Panier;
        $this->getUser()->setAttribute('Panier',$Panier,$request);

        //$session = $request->getSession();
        //$session->set('Panier', $Panier);

        return $this->Redirection_origine();

    }
    public function suppMenuPanierAction($idMenu,Request $request)
    {


        if($idMenu == null)
            return $this->Redirection_origine();

        $em = $this->getDoctrine()->getManager();
        $Plat = $em->getRepository('AvekApetiBackBundle:Plat')->find($idMenu);
        $Panier =  $this->getUser()->getAttribute('Panier',$request);
        if($Panier)
        {
            $Panier = $this->menuSuppr($Plat,$Panier);
            $this->getUser()->setAttribute('Panier',$Panier,$request);

        }else
        {
            //L'utilisateur commande des plats de different chef
            //Different message d'erreur en fonction
            return $this->Redirection_origine();
        }
        return $this->Redirection_origine();
    }

    private function menuExiste($Menu,$Panier)
    {
        $tableauMenu = $Panier->getTableauMenus();
        if (count($tableauMenu) != 0) {
            foreach ($tableauMenu as $menuPanier) {
                if ($menuPanier->getMenu()->getId() == $Menu->getId()) {

                    $menuPanier->setQuantity($menuPanier->getQuantity() + 1);
                    return true;
                }
            }
        }
        $menuPanier = new MenuPanier;
        $menuPanier->setMenu($Menu);
        $menuPanier->setQuantity(1);
        $menuPanier->setTliv();
        $menuPanier->setTcoms();

        $Panier->addTableauMenus($menuPanier);
        return false;
    }
    private function  menuSuppr($Menu,$Panier)
    {
        $tableauMenu = $Panier->getTableauMenus();
        $c = 0;
        foreach ($tableauMenu as $menuPanier){
            if($menuPanier->getMenu()->getId() == $Menu->getId()) {
                if ($menuPanier->getQuantity() > 1) {
                    $menuPanier->setQuantity($menuPanier->getQuantity() - 1);
                }else
                {

                    $Panier->supTableauMenus($c);
                }
            }
            $c++;
        }
        return $Panier;
    }
    public function widgetPanierAction(){
        return $this->render('GourmetBundle:Panier:widgetPanier.html.twig');
    }
}
