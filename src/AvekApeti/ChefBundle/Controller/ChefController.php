<?php

namespace AvekApeti\ChefBundle\Controller;

use lib\LemonWay\LemonWayKit;
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

    public function profilPublicAction()
    {
        //Recuperation de l'utilisateur connecté et recuperation de son id
        $user =$this->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Chef')->findOneByUtilisateur($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chef .');
        }

        /*$editForm->add('submit', 'submit', array('label' => 'Update'));*/

        return $this->render('ChefBundle:Chef:profil-public.html.twig', array(
            'entity'      => $entity,
            'entityChef'      => $user,
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
            'validation_groups' => array('Default', 'geoloc')
        ));
        $editForm->add('submit', 'submit', array('label' => 'Update'));

        $oldIban = $entity->getIban();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            // TODO : HasLifecycleCallbacks
            $curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
            $geocoder = new \Geocoder\Provider\GoogleMaps($curl);
            $dataGeo = $geocoder->geocode($editForm->get('adress')->getData().', '.$editForm->get('cp')->getData().', '.$editForm->get('city')->getData())->first();
            $entity->setLng($dataGeo->getLongitude());
            $entity->setLat($dataGeo->getLatitude());

            if ($entity->getIban() && $entity->getIban() != $oldIban)
            {
                $res = LemonWayKit::RegisterIBAN(
                    [
                        'wallet' => $entity->getUtilisateur()->getWalletLemonWay(),
                        'holder' => $entity->getUtilisateur()->getFirstname().' '.$entity->getUtilisateur()->getLastname(),
                        'iban' => $entity->getIban()
                    ]);

                if (isset($res->lwError)) {
                    $this->addFlash('error_iban_chef', 'Veuillez vérifier votre IBAN');
                    return $this->redirect($this->generateUrl('chef_plat'));
                }

            }

            $em->flush();

            return $this->redirect($this->generateUrl('chef_plat'));
        }

        return $this->render('ChefBundle:Chef:profil.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'entityChef'      => $user
        ));
    }

}
