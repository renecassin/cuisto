<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AvekApeti\BackBundle\Entity\Utilisateur;
use AvekApeti\GourmetBundle\Form\UtilisateurType;
use AvekApeti\BackBundle\Entity\Chef;
use AvekApeti\GourmetBundle\Form\ChefType;
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
            ->findOneByRole('ROLE_GOURMET');

        //Groupe est inject� pour definir le droit de l'utilisateur
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
            $em->flush();

            return $this->redirect($this->generateUrl('gourmet_homepage'));
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
           $em->flush();
          // $user->isEqualTo($user);
        }else
       {
           $em = $this->getDoctrine()->getManager();
           $entity =$em->getRepository("AvekApetiBackBundle:Chef")
               ->findOneByUtilisateur($user->getId());
       }
        return $this->redirect($this->generateUrl('chef_profil'));



    }

}
