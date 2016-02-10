<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AvekApeti\BackBundle\Entity\Utilisateur;
use AvekApeti\GourmetBundle\Form\UtilisateurType;
use AvekApeti\BackBundle\Entity\Chef;
use AvekApeti\GourmetBundle\Form\ChefType;
use lib\LemonWay\LemonWayKit;

class ChefController extends Controller
{
    public function chefInscriptionAction()
    {
        $entity = new Utilisateur();
        $form   = $this->createCreateForm($entity);

        return $this->render('GourmetBundle:Chef:chef-inscription.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }
    public function createAction(Request $request)
    {
        //Determine l'objet groupe avec le nom ROLE_GOURMET, definit ensuite le droit de l'utilisateur
        //Le groupe doit exister en base de donné
        $em = $this->getDoctrine()->getManager();
        $Groupe =$em->getRepository("AvekApetiBackBundle:Groupe")
            ->findOneByRole('ROLE_CHEF');

        //Groupe est injecte pour definir le droit de l'utilisateur
        $entity = new Utilisateur($Groupe);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            //Encodage du mot de passe
            $factory = $this->get('security.encoder_factory');
            $hash = $factory->getEncoder($entity)->encodePassword($entity->getPassword(),$entity->getSalt());
            $entity->setPassword($hash);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            $chef = new Chef();
            $chef->setUtilisateur($entity);
            $em->persist($chef);


            // create id lemon way
            $this->registerWallet($entity);

            $em->flush();

            //connection automatique
            $token = new UsernamePasswordToken($entity, null, 'main', array('ROLE_CHEF'));
            $this->get('security.context')->setToken($token);

            $this->addFlash(
                'notice_chef_compte',
                'N\'oubliez pas de renseigner votre adresse (dans la rubrique "Modifier mon profil") si vous voulez que les gourmets vous retrouvent :-)'
            );

            return $this->redirect($this->generateUrl('chef_profil'));

            //return $this->redirect($this->generateUrl('gourmet_loginpage'));
        }

        return $this->render('GourmetBundle:Chef:chef-inscription.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Creates a form to create a Utilisateur entity.
     *
     * @param Utilisateur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Utilisateur $entity)
    {
        $form = $this->createForm(new UtilisateurType(), $entity, array(
            'action' => $this->generateUrl('gourmet_chef_inscription_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }
    public function enregistrementAction()
    {
        //n'autorise que les gourmets
        $this->denyAccessUnlessGranted('ROLE_GOURMET', null, 'Unable to access this page!');
        //Recuperation id user
        $user =$this->get('security.context')->getToken()->getUser();

       if(!($this->get('security.authorization_checker')->isGranted('ROLE_CHEF'))) {

           //Recupere les droits chef
           $em = $this->getDoctrine()->getManager();
           $Groupe =$em->getRepository("AvekApetiBackBundle:Groupe")
               ->findOneByRole('ROLE_CHEF');

           $user->setGroupe($Groupe);

           $entity = new Chef();
           $entity->setUtilisateur($user);

           $em = $this->getDoctrine()->getManager();
           $em->persist($entity);
           $em->persist($user);

           // create id lemon way
           $this->registerWallet($user);

           $em->flush();
           // $user->isEqualTo($user);

           //connection automatique
           $token = new UsernamePasswordToken($user, null, 'main', array('ROLE_CHEF'));
           $this->get('security.context')->setToken($token);

           $this->addFlash(
               'notice_chef_compte',
               'N\'oubliez pas de renseigner votre adresse si vous voulez que les gourmets vous retrouvent :-)'
           );

           $this->addFlash(
               'notice_chef_compte',
               'N\'oubliez pas de renseigner votre RIB pour que vous puissiez recevoir les paiements des gourmets qui ont dégusté vos bons petits plats'
           );

           return $this->redirect($this->generateUrl('chef_profil'));
       }

        return $this->redirect($this->generateUrl('gourmet_homepage'));
    }


    private function registerWallet($user)
    {
        $wallet = $this->getRandomId();
        $res = LemonWayKit::RegisterWallet(['wallet' => $wallet,
            'clientMail' => $user->getEmail(),
            'clientTitle' => 'U',
            'clientFirstName' => $user->getFirstname(),
            'clientLastName' => $user->getLastname(),
            'payerOrBeneficiary' => '2']);

        if (isset($res->lwError))
            throw $this->createNotFoundException('Erreur lors de la création de votre wallet. Veuillez contactez le service technique.');
        else {
            $user->setWalletLemonWay((string)$res->wallet->ID);
        }
    }

    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Chef')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chef entity.');
        }

        return $this->render('GourmetBundle:Chef:index-chef.html.twig', array(
            'entity'      => $entity->getUtilisateur(),
            'entityChef'      => $entity,
        ));
    }

    /*
		Generate random ID for wallet IDs or tokens
	*/
    private function getRandomId(){
        return str_replace('.', '', microtime(true).rand());
    }

}
