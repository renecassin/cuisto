<?php

namespace AvekApeti\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AvekApeti\BackBundle\Entity\Commande;
use AvekApeti\BackBundle\Form\CommandeType;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{

    /**
     * Lists all Commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvekApetiBackBundle:Commande')->findAll();

        return $this->render('AvekApetiBackBundle:Commande:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Commande entity.
     *
     */
    public function createAction(Request $request)
    {

        $entity = new Commande();
        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);

        $CommandeType = new CommandeType;
        $PostData = $request->request->get($CommandeType->getName());
        //die(dump($PostData));
        $isPlats = ($PostData['liste_plats'] == '')? false : true ;
        $isMenus = ($PostData['liste_menus'] == '')? false : true ;
        $listeMenus = Array();
        $listePlats = Array();
        if($isPlats)
            $listePlats =$PostData['liste_plats'];
        if($isMenus)
            $listeMenus = $PostData['liste_menus'];


    //    die(dump($form));
        if ($form->isValid() && ($isPlats || $isMenus)) {

            $em = $this->getDoctrine()->getManager();
            $CollectionPLats =
            $Chef = "";
            foreach ($listePlats as $plat) {
                // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
                $commandePlat = new CommandePlat();

                // On la lie à l'annonce, qui est ici toujours la même
                $commandePlat->setCommande($entity);
                // On la lie à la compétence, qui change ici dans la boucle foreach
                $commandePlat->setPlat($plat[0]);

                // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
                $commandePlat->setQuantity($plat[1]);

                // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
                //$em->persist($commandePlat);
                $entity->addCommandeplat($commandePlat);
            }
            foreach ($listeMenus as $menu) {
                // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
                $commandeMenu = new CommandeMenu();

                // On la lie à l'annonce, qui est ici toujours la même
                $commandeMenu->setCommande($entity);
                // On la lie à la compétence, qui change ici dans la boucle foreach
                $commandeMenu->setMenu($menu[0]);

                // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
                $commandeMenu->setQuantity($menu[1]);

                // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
               // $em->persist($commandeMenu);
                $entity->addCommandemenu($commandeMenu);
            }
            $entity->setCommandePlat();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('commande_show', array('id' => $entity->getId())));
        }

        return $this->render('AvekApetiBackBundle:Commande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Commande entity.
     *
     * @param Commande $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Commande $entity)
    {
        $form = $this->createForm(new CommandeType(), $entity, array(
            'action' => $this->generateUrl('commande_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Commande entity.
     *
     */
    public function newAction()
    {
        $entity = new Commande();
        $form   = $this->createCreateForm($entity);

        return $this->render('AvekApetiBackBundle:Commande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Commande entity.
     *
     */
    public function showAction(Commande $entity)
    {
        //$em = $this->getDoctrine()->getManager();

       // $entity = $em->getRepository('AvekApetiBackBundle:Commande')->find($id);
        //die(dump($entity));
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commande entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());

        // On avait déjà récupéré la liste des candidatures
        $listCommandeMenus = $em
            ->getRepository('AvekApetiBackBundle:Menu')
            ->findBy(array('commande' => $entity))
        ;

        // On récupère maintenant la liste des AdvertSkill
        $listCommandePlats = $em
            ->getRepository('AvekApetiBackBundle:Plat')
            ->findBy(array('commande' => $entity))
        ;
        return $this->render('AvekApetiBackBundle:Commande:show.html.twig', array(
            'entity'      => $entity,
            'listePlats'      => $listCommandePlats,
            'ListeMenus'      => $listCommandeMenus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Commande entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Commande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commande entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AvekApetiBackBundle:Commande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Commande entity.
    *
    * @param Commande $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Commande $entity)
    {
        $form = $this->createForm(new CommandeType(), $entity, array(
            'action' => $this->generateUrl('commande_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Commande entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Commande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('commande_edit', array('id' => $id)));
        }

        return $this->render('AvekApetiBackBundle:Commande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Commande entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AvekApetiBackBundle:Commande')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Commande entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('commande'));
    }

    /**
     * Creates a form to delete a Commande entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
