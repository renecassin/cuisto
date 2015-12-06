<?php

namespace AvekApeti\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AvekApeti\BackBundle\Entity\Mail;
use AvekApeti\BackBundle\Form\MailType;

/**
 * Mail controller.
 *
 */
class MailController extends Controller
{

    /**
     * Lists all Mail entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:Mail')->findAll();

        return $this->render('AvekApetiBackBundle:Mail:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Mail entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Mail();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mail_show', array('id' => $entity->getId())));
        }

        return $this->render('AvekApetiBackBundle:Mail:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Mail entity.
     *
     * @param Mail $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Mail $entity)
    {
        $form = $this->createForm(new MailType(), $entity, array(
            'action' => $this->generateUrl('mail_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Mail entity.
     *
     */
    public function newAction()
    {
        $entity = new Mail();
        $form   = $this->createCreateForm($entity);

        return $this->render('AvekApetiBackBundle:Mail:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Mail entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Mail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AvekApetiBackBundle:Mail:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Mail entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Mail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mail entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AvekApetiBackBundle:Mail:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Mail entity.
    *
    * @param Mail $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mail $entity)
    {
        $form = $this->createForm(new MailType(), $entity, array(
            'action' => $this->generateUrl('mail_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Mail entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Mail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mail_edit', array('id' => $id)));
        }

        return $this->render('AvekApetiBackBundle:Mail:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Mail entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AvekApetiBackBundle:Mail')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mail entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mail'));
    }

    /**
     * Creates a form to delete a Mail entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mail_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
