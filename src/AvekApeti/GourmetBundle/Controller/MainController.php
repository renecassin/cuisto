<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AvekApeti\BackBundle\Entity\Mail;
use AvekApeti\GourmetBundle\Form\MailType;
class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('GourmetBundle:Main:index.html.twig');
    }

    public function loginAction(Request $request)
    {

        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('gourmet_homepage');
        }
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'GourmetBundle:Main:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );

    }

    public function contactAction(Request $request)
    {

        $entity = new Mail();

        $form = $this->createForm(new MailType(), $entity, array(
            'action' => $this->generateUrl('gourmet_contactpage'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            //Recuperation des informations utilisateur si il est logé
            $user =$this->get('security.context')->getToken()->getUser();
            if($user != "anon.")
            {
                if($user->getUsername() != 'admin@admin') {
                    $entity->setUtilisateur($user);
                }
            }
            $entity->setItem("Contact");
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gourmet_homepage'));
        }
        return $this->render('GourmetBundle:Main:contact.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }

    public function feedbackAction(Request $request)
    {
        $entity = new Mail();

        $form = $this->createForm(new MailType(), $entity, array(
            'action' => $this->generateUrl('gourmet_feedbackpage'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);


        if ($form->isValid()) {
            //Recuperation des informations utilisateur si il est logé
            $user =$this->get('security.context')->getToken()->getUser();
          //  die(dump($user));;
            if($user != "anon.")
            {
                if($user->getUsername() != 'admin@admin') {
                    $entity->setUtilisateur($user);
                }
            }
            $entity->setItem("Feedback");
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gourmet_homepage'));
        }
        return $this->render('GourmetBundle:Main:feedback.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }



}
