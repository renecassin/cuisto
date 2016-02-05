<?php

namespace AvekApeti\GourmetBundle\Controller;

use AvekApeti\BackBundle\Entity\Commande;
use AvekApeti\BackBundle\Entity\CommandePlat;
use AvekApeti\BackBundle\Entity\Message;
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
        // TODO : faire un test pour savoir si on peut commander (quantité et temps)
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
            throw $this->createNotFoundException('Erreur lors de la création de votre commande. Veuillez contacter le service technique.');
        }


        return new Response(LemonWayKit::printCardForm($res2->lwXml->MONEYINWEB->TOKEN, ''));
    }

    /**
     * Success payment
     * @param Request $request
     */
    public function donePaymentAction(Request $request)
    {
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
        $commande->setContent('');
        $commande->setLivraison(NULL);
        $commande->setStatus(0);
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
        $chef = $em->getRepository("AvekApetiBackBundle:Chef")->find($panier->getChefSelect()->getId());
        $commande->setChef($chef);


        $em->persist($commande);
        $em->flush();

        $user->resetAttribute('Panier',$request);

        /*
        $message = \Swift_Message::newInstance()
            ->setSubject('Avekapeti - code de validation de la commande')
            ->setFrom('contact@avekapeti.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'GourmetBundle:Email:commande-code.html.twig'
                ),
                'text/html'
            )
            ->addPart(
                $this->renderView(
                    'GourmetBundle:Email:commande-code.txt.twig'
                ),
                'text/plain'
            );

        $this->get('mailer')->send($message);
        */


        $messageChat = new Message();
        $messageChat->setEmetteurUser($user);
        $messageChat->setDestUser($chef->getUtilisateur());
        $messageChat->setItem("Commande du ".date('Y-m-d H:i:s'));
        $messageChat->setAccLecture(0);
        $messageChat->setContent("Bonjour,\nJe viens de vous commander un plat");

        $em->persist($messageChat);
        $em->flush();

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
        $this->addFlash('cancel_payment_command', "Un problème s'est produit lors du paiement. Veuillez réessayer ou contacter l'équipe technique.");
        return $this->redirectToRoute('panier_index');
    }

    public function codeValidCommandAction($id, $code)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $Chef = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($user->getId());

        $commande = $em->getRepository('AvekApetiBackBundle:Commande')->getOneByC($Chef->getId(),$id);

        if ($commande->getCodeCommand() != $code || $commande->getStatus() !== 0)
        {
            $this->addFlash('error_code_command', 'Le code est erroné');
        }
        else
        {
            $commande->setStatus(1);
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
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $Chef = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($user->getId());

        $commande = $em->getRepository('AvekApetiBackBundle:Commande')->getOneByC($Chef->getId(),$id);

        if ($commande->getStatus() !== 0)
        {
            $this->addFlash('error_cancel_command', 'Vous ne pouvez pas annuler cette commande');
        }
        else {

            $res = LemonWayKit::RefundMoneyIn(['transactionId' => $commande->getIdLemonWay()]);
            if (isset($res->lwError)) {
                $this->addFlash('error_cancel_command', 'Vous ne pouvez pas annuler cette commande');
            } else {
                $commande->setStatus(2);
                $this->addFlash('success_cancel_command', 'La commande a bien été annulée');
                $em->flush();
            }
        }

        return $this->redirectToRoute('chef_commande_details', ['id' => $id]);
    }

    public function cancelCommandGourmetAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('AvekApetiBackBundle:Commande')->getOneByG($user->getId(),$id);

        if ($commande->getStatus() !== 0)
        {
            $this->addFlash('error_cancel_command', 'Vous ne pouvez pas annuler cette commande');
        }
        else {
            $res = LemonWayKit::RefundMoneyIn(['transactionId' => $commande->getIdLemonWay(), 'amountToRefund' => number_format($commande->getCommission(), 2)]);
            if (isset($res->lwError)) {
                $this->addFlash('error_cancel_command', 'Vous ne pouvez pas annuler cette commande');
            } else {
                $commande->setStatus(3);
                $this->addFlash('success_cancel_command', 'La commande a bien été annulée');
                $em->flush();
            }
        }
        return $this->redirectToRoute('gourmet_commande_details', ['id' => $id]);
    }

    public function getMoneyChefAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $Chef = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($user->getId());

        if (!$Chef->getIban() || !$user->getWalletLemonWay())
        {
            $this->addFlash('error_money_recup', 'Vérifiez que vous avez rentré un IBAN');
        }
        else
        {
            $res = LemonWayKit::GetWalletDetails(
                [
                    'wallet' => $user->getWalletLemonWay(),
                ]);

            if (isset($res->lwError))
            {
                $this->addFlash('error_money_recup', "Problème avec votre wallet. Veuillez contacter l'équipe technique");
            }
            else
            {
                die(dump($res));
                $res = LemonWayKit::RegisterWallet(
                    [
                        'wallet' => $user->getWalletLemonWay(),
                        'amountTot' => 15.00
                    ]);
            }
        }

        die('récup du cash');
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
            throw $this->createNotFoundException('Erreur lors de la création de votre wallet. Veuillez contacter le service technique.');
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