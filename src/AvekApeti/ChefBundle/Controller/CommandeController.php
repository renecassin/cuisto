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
            'entities' => $entities,
        ));

    }

}