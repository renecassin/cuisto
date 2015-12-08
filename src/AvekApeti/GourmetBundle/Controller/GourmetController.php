<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AvekApeti\BackBundle\Entity\Utilisateur;
use AvekApeti\GourmetBundle\Form\UtilisateurType;
use AvekApeti\GourmetBundle\Form\Utilisateur2Type;
class GourmetController extends Controller
{
    public function gourmetInscriptionAction()
    {
        $entity = new Utilisateur();
        $form   = $this->createCreateForm($entity);

        return $this->render('GourmetBundle:Gourmet:gourmet-inscription.html.twig', array(
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

        return $this->render('GourmetBundle:Gourmet:gourmet-inscription.html.twig', array(
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
            'action' => $this->generateUrl('gourmet_gourmet_inscription_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    public function profilAction()
    {
        //Recuperation de l'utilisateur connecté et recuperation de son id
        $user =$this->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Utilisateur .');
        }

        $editForm = $this->createForm(new Utilisateur2Type(), $entity, array(
            'action' => $this->generateUrl('gourmet_update'),
            'method' => 'PUT',
        ));

        $editForm->add('submit', 'submit', array('label' => 'Update'));

        return $this->render('GourmetBundle:Gourmet:profil.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),

        ));
    }

    public function updateAction(Request $request)
    {

        $postData = $request->request->get('avekapeti_gourmetbundle_utilisateur');

        //Recuperation de l'utilisateur connecté et recuperation de son id
        $user =$this->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AvekApetiBackBundle:Utilisateur')->find($id);


        //Verifie si le mot de passe a ete changer si oui on le rencode
        if(  ($postData['password'] != null) )
        {


            //Encodage du mot de passe
            $factory = $this->get('security.encoder_factory');
            $hash = $factory->getEncoder($entity)->encodePassword($postData['password'],$entity->getSalt());
            $postData['password'] = $hash;
            $request->request->set('avekapeti_gourmetbundle_utilisateur',  $postData );

        }else{

            $request->request->set('avekapeti_gourmetbundle_utilisateur',  $entity->getPassword() );
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Utilisateur entity.');
        }

        $editForm = $this->createForm(new Utilisateur2Type(), $entity, array(
            'action' => $this->generateUrl('gourmet_profil'),
            'method' => 'PUT',
        ));

        $editForm->add('submit', 'submit', array('label' => 'Update'));
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->flush();

            return $this->redirect($this->generateUrl('gourmet_profil'));
        }

        return $this->render('AvekApetiGourmetBundle:Gourmet:profil.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
}
