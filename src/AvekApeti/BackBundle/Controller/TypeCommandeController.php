<?php

namespace AvekApeti\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AvekApeti\BackBundle\Entity\TypeCommande;
use AvekApeti\BackBundle\Form\TypeCommandeType;

/**
 * TypeCommande controller.
 *
 */
class TypeCommandeController extends Controller
{

    /**
     * Lists all TypeCommande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:TypeCommande')->findAll();

        return $this->render('AvekApetiBackBundle:TypeCommande:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TypeCommande entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TypeCommande();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('typecommande_show', array('id' => $entity->getId())));
        }

        return $this->render('AvekApetiBackBundle:TypeCommande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TypeCommande entity.
     *
     * @param TypeCommande $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeCommande $entity)
    {
        $form = $this->createForm(new TypeCommandeType(), $entity, array(
            'action' => $this->generateUrl('typecommande_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TypeCommande entity.
     *
     */
    public function newAction()
    {
        $entity = new TypeCommande();
        $form   = $this->createCreateForm($entity);

        return $this->render('AvekApetiBackBundle:TypeCommande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeCommande entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:TypeCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeCommande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AvekApetiBackBundle:TypeCommande:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeCommande entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:TypeCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeCommande entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AvekApetiBackBundle:TypeCommande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TypeCommande entity.
    *
    * @param TypeCommande $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TypeCommande $entity)
    {
        $form = $this->createForm(new TypeCommandeType(), $entity, array(
            'action' => $this->generateUrl('typecommande_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TypeCommande entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:TypeCommande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeCommande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('typecommande_edit', array('id' => $id)));
        }

        return $this->render('AvekApetiBackBundle:TypeCommande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TypeCommande entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AvekApetiBackBundle:TypeCommande')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeCommande entity.');
            }
            $entity->setSupp('1');

            $em->flush();
        }

        return $this->redirect($this->generateUrl('typecommande'));
    }

    /**
     * Creates a form to delete a TypeCommande entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typecommande_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Supprimer',
                'attr'  => array('class' => 'btn btn-warning')
            ))
            ->getForm()
        ;
    }
}
