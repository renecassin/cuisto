<?php

namespace AvekApeti\ChefBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AvekApeti\BackBundle\Entity\Chef;
use AvekApeti\ChefBundle\Form\ChefType;

class ChefController extends Controller
{
    public function profilAction()
    {
        //Recuperation de l'utilisateur connecté et recuperation de son id
        $user =$this->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chef .');
        }

        $editForm = $this->createForm(new ChefType(), $entity, array(
            'action' => $this->generateUrl('chef_chef_update'),
            'method' => 'PUT',
        ));

        /*$editForm->add('submit', 'submit', array('label' => 'Update'));*/

        return $this->render('ChefBundle:Chef:profil.html.twig', array(
            'entity'      => $entity,
            'entityChef'      => $user,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function updateAction(Request $request)
    {
        $user =$this->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chef entity.');
        }

        $editForm = $this->createForm(new ChefType(), $entity, array(
            'action' => $this->generateUrl('chef_chef_update'),
            'method' => 'PUT',
        ));
        $editForm->add('submit', 'submit', array('label' => 'Update'));

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('chef_profil'));
        }

        return $this->render('ChefBundle:Chef:profil.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

}
