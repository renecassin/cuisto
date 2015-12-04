<?php

namespace AvekApeti\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item')
            ->add('content')
            ->add('emetteur_user', 'entity',  array(
                'class' => 'AvekApetiBackBundle:Utilisateur',
                'choice_label' => 'email',
                "multiple" => false,
                "expanded" => false
            ))
            ->add('dest_user', 'entity',  array(
                'class' => 'AvekApetiBackBundle:Utilisateur',
                'choice_label' => 'email',
                "multiple" => false,
                "expanded" => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AvekApeti\BackBundle\Entity\Message'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'avekapeti_backbundle_message';
    }
}
