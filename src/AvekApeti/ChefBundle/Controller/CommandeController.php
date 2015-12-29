<?php

namespace AvekApeti\ChefBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CommandeController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $id = $user->getId();
        $entity = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($id);

        $entities = $em->getRepository('AvekApetiBackBundle:Commande')->findByChef($entity);

        return $this->render('ChefBundle:Commande:commande.html.twig', array(
            'entityUser' => $user,
            'entities' => $entities,
        ));

    }
    public function showAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $Chef = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($user->getId());

        $entity = $em->getRepository('AvekApetiBackBundle:Commande')->getOneByC($Chef->getId(),$id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commande entity.');
        }


        return $this->render('ChefBundle:Commande:show.html.twig', array(
            'entityUser' => $user,
            'entity'      => $entity,
        ));
    }
}