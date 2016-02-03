<?php

namespace AvekApeti\GourmetBundle\Controller;

use AvekApeti\BackBundle\Entity\Commande;
use AvekApeti\BackBundle\Entity\CommandePlat;
use lib\LemonWay\LemonWayKit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if (!$user->getWalletLemonWay())
        {
            $this->registerWallet($user);
            $em->persist($user);
            $em->flush();
        }


        $panier = $user->getAttribute('Panier',$request);
        $totalCommande = number_format(round($panier->getTableauPlatsTotal(), 2), 2);
        $commissionAvekapeti = number_format(round($totalCommande * ( 12 / 100 ), 2), 2);

        $res2 = LemonWayKit::MoneyInWebInit(
            array(
                'wkToken'       =>  $this->getRandomId(),
                'wallet'        =>  $user->getWalletLemonWay(),
                'amountTot'     =>  $totalCommande,
                'amountCom'     =>  $commissionAvekapeti,
                'comment'       =>  "Commande du ".date('Y-m-d H:i:s')." par : ".$user->getFirstname()." ".$user->getLastname(),
                'returnUrl'     =>  urlencode($this->generateUrl('gourmet_payment_done', [], true)),
                'cancelUrl'     =>  urlencode($this->generateUrl('gourmet_payment_cancel', [], true)),
                'errorUrl'      =>  urlencode($this->generateUrl('gourmet_payment_error', [], true)),
                'autoCommission'=>  '0'
            ));

        if (isset($res2->lwError)){
            throw $this->createNotFoundException('Erreur lors de la création de votre commande. Veuillez contactez le service technique.');
        }


        return new Response(LemonWayKit::printCardForm($res2->lwXml->MONEYINWEB->TOKEN, ''));
    }

    /**
     * Success payment
     * @param Request $request
     */
    public function donePaymentAction(Request $request)
    {
        // TODO : faire un test pour savoir si on peut commander (quantité et temps)
        if(!$this->getUser()->hasAttribute('Panier',$request))
        {
            return $this->redirectToRoute('gourmet_homepage');
        }

        $token = $request->query->get('response_wkToken');
        if (!$token)
        {
            return $this->redirectToRoute('gourmet_homepage');
        }

        $returnPayment = LemonWayKit::GetMoneyInTransDetails(['transactionMerchantToken' => $token]);
        if (isset($returnPayment->lwError)) {
            throw $this->createNotFoundException('Erreur lors de la récupération de votre commande.');
        }

        $user = $this->getUser();
        $panier = $user->getAttribute('Panier',$request);
        $infoCommande = $returnPayment->lwXml->TRANS->HPAY;

        $commande = new Commande();
        $commande->setContent('A remplacer par le texte utilisateur lors de la commande');
        $commande->setLivraison(NULL);
        $commande->setStatus("En attente");
        $commande->setTotal((string)$infoCommande->CRED);
        $commande->setUtilisateur($user);
        $commande->setCodeCommand(uniqid());
        $commande->setCommission((string)$infoCommande->COM);
        $commande->setIdLemonWay((string)$infoCommande->ID);

        $em = $this->getDoctrine()->getManager();
        // Add plat
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


        $em->persist($commande);
        $em->flush();

        $user->resetAttribute('Panier',$request);

        // TODO : mail de confirmation de commande avec le code

        // TODO : message de confirmation

        $this->addFlash('success_command', 'Votre commande a bien été prise en compte');
        return $this->redirectToRoute('gourmet_commande');
    }

    /**
     * cancel payment
     * @param Request $request
     */
    public function cancelPaymentAction(Request $request)
    {
        $this->addFlash('cancel_payment_command', 'Vous avez annulé votre commande');
        return $this->redirectToRoute('panier_index');
    }

    /**
     * error payment
     * @param Request $request
     */
    public function errorPaymentAction()
    {
        // TODO : send mail to avekapeti
        $this->addFlash('cancel_payment_command', "Un produit s'est produit lors du paiement. Veuillez réessayer ou contacter l'équipe technique.");
        return $this->redirectToRoute('panier_index');
    }

    public function codeValidCommandAction($id, $code)
    {
        // TODO : faire un test pour savoir si on peut valider le code
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $Chef = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($user->getId());

        $commande = $em->getRepository('AvekApetiBackBundle:Commande')->getOneByC($Chef->getId(),$id);

        if ($commande->getCodeCommand() != $code)
        {
            $this->addFlash('error_code_command', 'Le code est erroné');
        }
        else
        {
            die('Vérifier débiteur et créditeur avec des utilisateurs différents');
            $commande->setStatus('Validée');
            // TODO : ajouter un state à la commande
            $res = LemonWayKit::SendPayment(
                [
                    'debitWallet' => $commande->getUtilisateur()->getWalletLemonWay(),
                    'creditWallet' => $Chef->getUtilisateur()->getWalletLemonWay(),
                    'amount' => $commande->getTotal(),
                ]);
            $this->addFlash('success_code_command', 'Code valide');
            $em->flush();
        }

        return $this->redirectToRoute('chef_commande_details', ['id' => $id]);
    }

    public function cancelCommandChefAction($id)
    {
        // TODO : faire un test pour savoir si on peut annuler
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $Chef = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($user->getId());

        $commande = $em->getRepository('AvekApetiBackBundle:Commande')->getOneByC($Chef->getId(),$id);

        $res = LemonWayKit::RefundMoneyIn(['transactionId' => $commande->getIdLemonWay()]);
        if (isset($res->lwError))
        {
            $this->addFlash('error_cancel_command', 'Vous ne pouvez pas annuler cette commande');
        }
        else
        {
            $commande->setStatus('Annulation du chef');
            // TODO : ajouter un state à la commande
            $this->addFlash('success_cancel_command', 'La commande a bien été annulée');
            $em->flush();
        }

        return $this->redirectToRoute('chef_commande_details', ['id' => $id]);
    }

    public function cancelCommandGourmetAction($id)
    {
        // TODO : faire un test pour savoir si on peut annuler
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('AvekApetiBackBundle:Commande')->getOneByG($user->getId(),$id);

        $res = LemonWayKit::RefundMoneyIn(['transactionId' => $commande->getIdLemonWay(), 'amountToRefund' => number_format($commande->getCommission(), 2)]);
        if (isset($res->lwError))
        {
            $this->addFlash('error_cancel_command', 'Vous ne pouvez pas annuler cette commande');
        }
        else
        {
            $commande->setStatus('Annulation du gourmet');
            // TODO : ajouter un state à la commande
            $this->addFlash('success_cancel_command', 'La commande a bien été annulée');
            $em->flush();
        }
        return $this->redirectToRoute('gourmet_commande_details', ['id' => $id]);
    }

    private function registerWallet($user)
    {
        $wallet = $this->getRandomId();
        $res = LemonWayKit::RegisterWallet(['wallet' => $wallet,
            'clientMail' => $user->getEmail(),
            'clientTitle' => 'U',
            'clientFirstName' => $user->getFirstname(),
            'clientLastName' => $user->getLastname(),
            'payerOrBeneficiary' => '1']);

        if (isset($res->lwError))
            throw $this->createNotFoundException('Erreur lors de la création de votre wallet. Veuillez contactez le service technique.');
        else {
            $user->setWalletLemonWay((string)$res->wallet->ID);
        }
    }

    /*
		Generate random ID for wallet IDs or tokens
	*/
    private function getRandomId(){
        return str_replace('.', '', microtime(true).rand());
    }
}