<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CommandeController extends Controller
{
    public function indexAction()
    {
        $User = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:Commande')->findByUtilisateur($User);

        return $this->render('GourmetBundle:Gourmet:commande.html.twig', array(
            'entities' => $entities,
        ));

    }

}