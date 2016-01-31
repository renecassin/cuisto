<?php

namespace AvekApeti\GourmetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AvekApeti\BackBundle\Entity\Utilisateur;
use AvekApeti\BackBundle\Entity\Image;
use AvekApeti\GourmetBundle\Form\UtilisateurType;
use AvekApeti\GourmetBundle\Form\Utilisateur2Type;
class GourmetController extends Controller
{
    public function gourmetInscriptionAction()
    {
        $entity = new Utilisateur();
        $form   = $this->createCreateForm($entity);

        return $this->render('GourmetBundle:Gourmet:gourmet-inscription.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }
    public function createAction(Request $request)
    {
        //Determine l'objet groupe avec le nom ROLE_GOURMET, definit ensuite le droit de l'utilisateur
        //Le groupe doit exister en base de donné
        $em = $this->getDoctrine()->getManager();
        $Groupe =$em->getRepository("AvekApetiBackBundle:Groupe")
            ->findOneByRole('ROLE_GOURMET');

        //Groupe est inject� pour definir le droit de l'utilisateur
        $entity = new Utilisateur($Groupe);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            //Encodage du mot de passe
            $factory = $this->get('security.encoder_factory');
            $hash = $factory->getEncoder($entity)->encodePassword($entity->getPassword(),$entity->getSalt());
            $entity->setPassword($hash);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('gourmet_loginpage'));

            //connection automatique
            $token = new UsernamePasswordToken($entity, null, 'main', array('ROLE_GOURMET'));
            $this->get('security.context')->setToken($token);

            return $this->redirect($this->generateUrl('gourmet_homepage'));
        }

        return $this->render('GourmetBundle:Gourmet:gourmet-inscription.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Utilisateur entity.
     *
     * @param Utilisateur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Utilisateur $entity)
    {
        $form = $this->createForm(new UtilisateurType(), $entity, array(
            'action' => $this->generateUrl('gourmet_gourmet_inscription_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    public function profilAction()
    {
        //Recuperation de l'utilisateur connecté et recuperation de son id
        $user =$this->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Utilisateur .');
        }

        $editForm = $this->createForm(new Utilisateur2Type(), $entity, array(
            'action' => $this->generateUrl('gourmet_update'),
            'method' => 'PUT',
        ));


        return $this->render('GourmetBundle:Gourmet:profil.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),

        ));
    }

    public function profilPublicAction()
    {
        //Recuperation de l'utilisateur connecté et recuperation de son id
        $user =$this->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvekApetiBackBundle:Utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Utilisateur .');
        }

        return $this->render('GourmetBundle:Gourmet:profil-public.html.twig', array(
            'entity'      => $entity,

        ));
    }

    /* public function updateAction(Request $request)
     {

         $postData = $request->request->get('avekapeti_gourmetbundle_utilisateur');

         //Recuperation de l'utilisateur connecté et recuperation de son id
         $user =$this->get('security.context')->getToken()->getUser();
         $id = $user->getId();

         $em = $this->getDoctrine()->getManager();
         $entity = $em->getRepository('AvekApetiBackBundle:Utilisateur')->find($id);


         //Verifie si le mot de passe a ete changer si oui on le rencode
         if(  ($postData['password'] != null) )
         {


             //Encodage du mot de passe
             $factory = $this->get('security.encoder_factory');
             $hash = $factory->getEncoder($entity)->encodePassword($postData['password'],$entity->getSalt());
             $postData['password'] = $hash;
             $request->request->set('avekapeti_gourmetbundle_utilisateur',  $postData );

         }else{

             $request->request->set('avekapeti_gourmetbundle_utilisateur',  $entity->getPassword() );
         }

         if (!$entity) {
             throw $this->createNotFoundException('Unable to find Utilisateur entity.');
         }

         $editForm = $this->createForm(new Utilisateur2Type(), $entity, array(
             'action' => $this->generateUrl('gourmet_profil'),
             'method' => 'PUT',
         ));

         $editForm->add('submit', 'submit', array('label' => 'Update'));
         $editForm->handleRequest($request);
        // dump($postData);
        //die( dump($editForm));
         if ($editForm->isValid()) {

             $em->flush();

             return $this->redirect($this->generateUrl('gourmet_profil'));
         }

         return $this->render('GourmetBundle:Gourmet:profil.html.twig', array(
             'entity'      => $entity,
             'edit_form'   => $editForm->createView()
         ));
     }*/
    public function updateAction(Request $request) {
        $user =$this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getEntityManager();

        $ancienMdp = $user->getPassword();
        $oldImage = $user->getImage();

        $Utilisateur2Type = new Utilisateur2Type(); // instancie le formulaire pour pouvoir utiliser getName() plus loin
        $editForm = $this->createForm($Utilisateur2Type, $user);


        // gestion du changement -ou non- de mot de passe
        $PostData = $request->request->get($Utilisateur2Type->getName());
        $isNewPassword = ($PostData['password'] == '')? false : true ;
        if(!$isNewPassword){
            // réinjection de l'ancien mot de passe dans la requête
            $PostData['password'] = $ancienMdp;
            $request->request->set($Utilisateur2Type->getName(), $PostData);
        }
        //$PostData['image']['user'] = $user->getId();
      /*  $isNewImage = ($PostData['image']['name'] == '')? false : true ;
        if(!$isNewImage){
            // réinjection de l'ancien mot de passe dans la requête
            $PostData['image']['name'] = $oldImage;
            $request->request->set($Utilisateur2Type->getName(), $PostData);
        }*/

        $editForm = $this->createForm(new Utilisateur2Type(), $user, array(
            'action' => $this->generateUrl('gourmet_profil'),
            'method' => 'PUT',
        ));

        $editForm->add('submit', 'submit', array('label' => 'Update'));
        $editForm->handleRequest($request);
       // die(dump($request->request->get($Utilisateur2Type->getName())));
        if ($editForm->isValid()) {

            if($isNewPassword){
                // encodage du nouveau mot de passe
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
            }
          //  if($isNewImage){
          //     $image = $user->getImage();
          //      $image->setUser($user->getId());
           //     $user->setImage($image);
           // }

            $em->persist($user);
            $em->flush();

            $user->setImage(new Image());
            return $this->redirect($this->generateUrl('gourmet_profil'));
        }

        // la validation n'est pas bonne, on réaffiche le formulaire avec les erreurs
        return $this->render('GourmetBundle:Gourmet:profil.html.twig', array(
            'entity' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }
}
