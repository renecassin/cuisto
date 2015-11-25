<?php

namespace AvekApeti\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('login')
            ->add('password')
            ->add('adress')
            ->add('city')
            ->add('cp')
            ->add('phone')
            ->add('salt')
            ->add('newsletter')
            ->add('image', new ImageType(), [
                "required" => false,
            ])
            ->add('groupe', 'entity',  array(
                'class' => 'AvekApetiBackBundle:Groupe',
                'choice_label' => 'name',
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
            'data_class' => 'AvekApeti\BackBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'avekapeti_backbundle_utilisateur';
    }
}
