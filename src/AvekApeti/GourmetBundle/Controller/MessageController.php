<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AvekApeti\BackBundle\Entity\Message;
use AvekApeti\GourmetBundle\Form\MessageType;
class MessageController extends Controller
{
    public function indexAction()
    {
        $User = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:Message')->getByEmetteur($User->getId());
        $entities2 = $em->getRepository('AvekApetiBackBundle:Message')->getByDest($User->getId());

        return $this->render('GourmetBundle:Message:index.html.twig', array(
            'entities' => $entities,
            'entities2' => $entities2,
        ));
    }
    /**
     * Creates a new Message entity.
     *
     */
    public function createAction(Request $request)
    {
        $User = $this->get('security.context')->getToken()->getUser();
        $postData = $request->request->get('gourmetbundle_message');


        $em = $this->getDoctrine()->getManager();
        $User_dest = $em->getRepository('AvekApetiBackBundle:Utilisateur')->findOneByLogin($postData['destinataire']);

        $entity = new Message();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid() && $User_dest) {

            $entity->setEmetteurUser($User);
            $entity->setDestUser($User_dest);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gourmet_message_show', array('id' => $entity->getId())));
        }

        return $this->render('GourmetBundle:Message:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'User_dest' => true
        ));
    }

    /**
     * Creates a form to create a Message entity.
     *
     * @param Message $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Message $entity)
    {
        $form = $this->createForm(new MessageType(), $entity, array(
            'action' => $this->generateUrl('gourmet_message_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Message entity.
     *
     */
    public function newAction()
    {
        $entity = new Message();
        $form   = $this->createCreateForm($entity);

        return $this->render('GourmetBundle:Message:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Message entity.
     *
     */
    public function showAction($id)
    {
        $User = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Message')->getOneByED($User->getId(),$id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Message entity.');
        }else{
            //Enregistrement de l'accusé de lecture
            $entity->setAccLecture(1);
            $em->persist($entity);
            $em->flush();
        }


        return $this->render('GourmetBundle:Message:show.html.twig', array(
            'entity'      => $entity,

        ));
    }



}