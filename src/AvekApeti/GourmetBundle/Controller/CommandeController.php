<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CommandeController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:Commande')->findByUtilisateur($user);

        return $this->render('GourmetBundle:Gourmet:commande.html.twig', array(
            'entityUser' => $user,
            'entities' => $entities,
        ));

    }

    public function showAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Commande')->getOneByG($user->getId(),$id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commande entity.');
        }


        return $this->render('GourmetBundle:Gourmet:show.html.twig', array(
            'entityUser' => $user,
            'entity'      => $entity,
        ));
    }

}