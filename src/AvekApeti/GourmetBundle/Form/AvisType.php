<?php

namespace AvekApeti\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvisType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note')
            ->add('comment')
            ->add('active')
            ->add('utilisateur', 'entity',  array(
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
            'data_class' => 'AvekApeti\BackBundle\Entity\Avis'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'avekapeti_backbundle_avis';
    }
}
