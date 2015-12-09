<?php

namespace AvekApeti\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('livraison')
            ->add('typecommande')
            ->add('plat','entity', array(
                'class' => 'AvekApetiBackBundle:Plat',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => true,
                'required' => false))
           ->add('menu','entity', array(
               'class' => 'AvekApetiBackBundle:Menu',
               'choice_label' => 'name',
               'expanded' => false,
               'multiple' => true,
               'required' => false))
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
