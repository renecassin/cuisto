<?php

namespace AvekApeti\ChefBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AvekApeti\BackBundle\Entity\Plat;
use AvekApeti\ChefBundle\Form\PlatType;

/**
 * Plat controller.
 *
 */
class PlatController extends Controller
{



    /**
     * Lists all Plat entities.
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:Plat')->findIfChef($user->getId());

        return $this->render('ChefBundle:Plat:index.html.twig', array(
            'entityChef' => $user,
            'entities' => $entities,

        ));
    }
    /**
     * Creates a new Plat entity.
     *
     */
    public function createAction(Request $request)
    {
        $user =$this->get('security.context')->getToken()->getUser();
        $entity = new Plat();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $image = $entity->getImage();
        if(is_object($image)) {
            $image->setUser($user->getId());
            $entity->setImage($image);
        }
        $entity->setUtilisateur($user);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setSupp("0");
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('chef_plat_show', array('id' => $entity->getId())));
        }

        return $this->render('ChefBundle:Plat:new.html.twig', array(
            'entityChef' => $user,
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Plat entity.
     *
     * @param Plat $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Plat $entity)
    {
        $form = $this->createForm(new PlatType(), $entity, array(
            'action' => $this->generateUrl('chef_plat_create'),
            'method' => 'POST',
        ));

        /*$form->add('submit', 'submit', array('label' => 'Create'));*/

        return $form;
    }

    /**
     * Displays a form to create a new Plat entity.
     *
     */
    public function newAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $entity = new Plat();
        $form   = $this->createCreateForm($entity);

        return $this->render('ChefBundle:Plat:new.html.twig', array(
            'entityChef' => $user,
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Plat entity.
     *
     */
    public function showAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Plat')->findOneIfChef($user->getId(),$id);

        $entities = $em->getRepository('AvekApetiBackBundle:Plat')->findIfChef($user->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ChefBundle:Plat:show.html.twig', array(
            'entities'      => $entities,
            'entityChef'      => $user,
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Plat entity.
     *
     */
    public function editAction($id)
    {
        $User = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Plat')->findOneIfChef($User->getId(),$id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plat entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ChefBundle:Plat:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Plat entity.
    *
    * @param Plat $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Plat $entity)
    {
        $form = $this->createForm(new PlatType(), $entity, array(
            'action' => $this->generateUrl('chef_plat_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        /*$form->add('submit', 'submit', array('label' => 'Update'));*/

        return $form;
    }
    /**
     * Edits an existing Plat entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $User = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Plat')->findOneIfChef($User->getId(),$id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('chef_plat_edit', array('id' => $id)));
        }

        return $this->render('ChefBundle:Plat:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Plat entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $User = $this->get('security.context')->getToken()->getUser();
        $plat = $em->getRepository('AvekApetiBackBundle:Plat')->findOneIfChef($User->getId(),$id);
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid() && ($User == $plat->getUtilisateur()) ) {

            $entity = $em->getRepository('AvekApetiBackBundle:Plat')->findOneIfChef($User->getId(),$id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Plat entity.');
            }
            $entity->setSupp('1');
            //$em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('chef_plat'));
    }

    /**
     * Creates a form to delete a Plat entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chef_plat_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Supprimer ce plat'))
            ->getForm()
        ;
    }
}
