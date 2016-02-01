<?php

namespace AvekApeti\GourmetBundle\Controller;

use AvekApeti\BackBundle\Entity\Commande;
use AvekApeti\BackBundle\Entity\CommandePlat;
use lib\LemonWay\LemonWayKit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PaymentController extends Controller
{
    /**
     * Get payment
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        if(!$this->getUser()->hasAttribute('Panier',$request))
        {
            return $this->redirectToRoute('panier_index');
        }

        $user = $this->getUser();
        /*
        if (!$user->getWalletLemonWay())
        {
            $this->registerWallet($user);
        }
        */

        $panier = $user->getAttribute('Panier',$request);
        $totalCommande = $panier->getTableauPlatsTotal();
        $commissionAvekapeti = $totalCommande * ( 12 / 100 );


        /* ----------- CREATION COMMANDE ------------
        $commande = new Commande();
        $commande->setContent('A remplacer par le texte utilisateur lors de la commande');
        $commande->setLivraison(NULL); //TODO : valider avec Fati que c'est dans le profil chef
        $commande->setStatus("En attente");
        $commande->setTotal($totalCommande);
        $commande->setUtilisateur($user);

        // Ajout de tous les plats
        $em = $this->getDoctrine()->getManager();

        foreach($panier->getTableauPlats() as $plat)
        {
            $commandePlat = new CommandePlat();
            // get real plat
            $currentPlat = $em->getRepository('AvekApetiBackBundle:Plat')->find($plat->getPlat()->getId());
            $commandePlat->setCommande($commande);
            $commandePlat->setPlats($currentPlat);
            $commandePlat->setQuantity($plat->getQuantity());
            $commande->addCommandeplat($commandePlat);
        }

        // get real chef
        $chef = $em->getRepository("AvekApetiBackBundle:Chef")->find($panier->getChefSelect()->getChef()->getId());
        $commande->setChef($chef);

        //die(dump($commande));
        $em->persist($commande);
        $em->flush();
        TODO : Ne pas oublier de créer un message standart lors de la commande
        die('creation de la commande');

        ----------- FIN CREATION COMMANDE ------------ */


        $res2 = LemonWayKit::MoneyInWebInit(array('wkToken'=>$this->getRandomId(),
            'wallet'=>$user->getWalletLemonWay(),
            'amountTot'=>$totalCommande,
            'amountCom'=>$commissionAvekapeti,
            'comment'=>'commande avekapeti',
            'returnUrl'=>urlencode($this->generateUrl('')),
            'cancelUrl'=>urlencode($this->generateUrl('')),
            'errorUrl'=>urlencode($this->generateUrl('')),
            'autoCommission'=>'0'));
        if (isset($res2->lwError)){
            print '<br/>Error, code '.$res2->lwError->CODE.' : '.$res2->lwError->MSG;
            die;
        }
        print '<br/>Init successul. LWTOKEN: '. $res2->lwXml->MONEYINWEB->TOKEN;
        LemonWayKit::printCardForm($res2->lwXml->MONEYINWEB->TOKEN, '');
    }

    /**
     * Success payment
     * @param Request $request
     */
    public function donePaymentAction(Request $request)
    {
        // TODO : redirection sur la page des commandes avec un message flash
        die('tout est ok');
    }

    /**
     * cancel payment
     * @param Request $request
     */
    public function cancelPaymentAction(Request $request)
    {
        die('il y a eu une annulation de paiement');
    }

    /**
     * error payment
     * @param Request $request
     */
    public function errorPaymentAction(Request $request)
    {
        die('il y a eu un problème');
    }

    private function registerWallet($user)
    {
        $wallet = $this->getRandomId();
        $res = LemonWayKit::RegisterWallet(['wallet' => $wallet,
            'clientMail' => $user->getEmail(),
            'clientTitle' => 'U',
            'clientFirstName' => $user->getFirstname(),
            'clientLastName' => $user->getLastname()]);
        die(dump($res));
        if (isset($res->lwError))
            print 'Error, code '.$res->lwError->CODE.' : '.$res->lwError->MSG;
        else
            print '<br/>Wallet created : ' . $res->wallet->ID;
    }

    /*
		Generate random ID for wallet IDs or tokens
	*/
    private function getRandomId(){
        return str_replace('.', '', microtime(true).rand());
    }
}