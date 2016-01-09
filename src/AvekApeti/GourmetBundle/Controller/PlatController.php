<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlatController extends Controller
{
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Plat')->find($id);

        $entities = $em->getRepository('AvekApetiBackBundle:Plat')->findIfChef($entity->getUtilisateur()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plat entity.');
        }

        return $this->render('GourmetBundle:Plat:index-plat.html.twig', array(
            'entities'      => $entities,
            'entityChef'      => $entity->getUtilisateur(),
            'entity'      => $entity,
        ));
    }

    public function selectionAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:Plat')->findAll();

        return $this->render('GourmetBundle:Plat:selection-plat.html.twig', array(
            'entities' => $entities,

        ));
    }
}
