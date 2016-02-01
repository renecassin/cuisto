<?php

namespace AvekApeti\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AvekApeti\BackBundle\Entity\TypeLivraison;
use AvekApeti\BackBundle\Form\TypeLivraisonType;

/**
 * TypeLivraison controller.
 *
 */
class TypeLivraisonController extends Controller
{

    /**
     * Lists all TypeLivraison entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:TypeLivraison')->findAll();

        return $this->render('AvekApetiBackBundle:TypeLivraison:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TypeLivraison entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TypeLivraison();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('typelivraison_show', array('id' => $entity->getId())));
        }

        return $this->render('AvekApetiBackBundle:TypeLivraison:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TypeLivraison entity.
     *
     * @param TypeLivraison $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeLivraison $entity)
    {
        $form = $this->createForm(new TypeLivraisonType(), $entity, array(
            'action' => $this->generateUrl('typelivraison_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TypeLivraison entity.
     *
     */
    public function newAction()
    {
        $entity = new TypeLivraison();
        $form   = $this->createCreateForm($entity);

        return $this->render('AvekApetiBackBundle:TypeLivraison:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeLivraison entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:TypeLivraison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeLivraison entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AvekApetiBackBundle:TypeLivraison:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeLivraison entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:TypeLivraison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeLivraison entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AvekApetiBackBundle:TypeLivraison:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TypeLivraison entity.
    *
    * @param TypeLivraison $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TypeLivraison $entity)
    {
        $form = $this->createForm(new TypeLivraisonType(), $entity, array(
            'action' => $this->generateUrl('typelivraison_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TypeLivraison entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:TypeLivraison')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeLivraison entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('typelivraison_edit', array('id' => $id)));
        }

        return $this->render('AvekApetiBackBundle:TypeLivraison:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TypeLivraison entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AvekApetiBackBundle:TypeLivraison')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeLivraison entity.');
            }
            $entity->setSupp('1');

            $em->flush();
        }

        return $this->redirect($this->generateUrl('typelivraison'));
    }

    /**
     * Creates a form to delete a TypeLivraison entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typelivraison_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Supprimer',
                'attr'  => array('class' => 'btn btn-warning')
            ))
            ->getForm()
        ;
    }
}
