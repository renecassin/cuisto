<?php

namespace AvekApeti\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
class CommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('total')
            ->add('status')
            ->add('Utilisateur', 'entity',  array(
                'class' => 'AvekApetiBackBundle:Utilisateur',
                'choice_label' => 'email',
                "multiple" => false,
                "expanded" => false
            ))
            ->add('Chef', 'entity',  array(
                'class' => 'AvekApetiBackBundle:Chef',
                'choice_label' => 'id',
                "multiple" => false,
                "expanded" => false
            ))
            ->add('content')
            ->add('typecommande','entity', array(
                'class' => 'AvekApetiBackBundle:TypeCommande',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'required' => false))
            ->add('livraison','entity', array(
                'class' => 'AvekApetiBackBundle:TypeLivraison',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'required' => false))
          /*  ->add('plat','entity', array(
                'class' => 'AvekApetiBackBundle:Plat',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => true,
                'required' => false))
            ->add('plat','collection', array(
              'type' => 'AvekApetiBackBundle:Plat',
               // 'class' => 'AvekApetiBackBundle:Plat',
                 'allow_add'    => true,
                'required' => false))
          /*  ->add('menu','entity', array(
                'class' => 'AvekApetiBackBundle:Menu',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => true,
                'required' => false))
           ->add('menu','collection', array(
            //   'class' => 'AvekApetiBackBundle:Menu',
               'type' => 'AvekApetiBackBundle:Menu',
               'allow_add'    => true,
               'required' => false))*/
             ->add('commandeplat', 'entity',
                 [
                     'class' => 'AvekApetiBackBundle:Plat',
                     'property'    => 'name',
                     'multiple' => false,
                     'mapped' => false
                 ])
            ->add('commandemenu', 'entity',
                [
                    'class' => 'AvekApetiBackBundle:Menu',
                    'property'    => 'name',
                    'multiple' => false,
                    'mapped' => false
                ])
            ->add('liste_plats','hidden',[
                'mapped' => false
            ])
            ->add('liste_menus','hidden',[
                'mapped' => false
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AvekApeti\BackBundle\Entity\Commande'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'avekapeti_backbundle_commande';
    }
}
