<?php

namespace AvekApeti\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlatType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('price')
            ->add('quantity')
            ->add('active')
            ->add('unableWhile')
            ->add('Utilisateur', 'entity',  array(
                'class' => 'AvekApetiBackBundle:Utilisateur',
                'choice_label' => 'email',
                "multiple" => false,
                "expanded" => false
            ))
            ->add('specialite', 'entity',  array(
                'class' => 'AvekApetiBackBundle:Specialite',
                'choice_label' => 'name',
                "multiple" => false,
                "expanded" => false
            ))
            ->add('categorie', 'entity',  array(
                'class' => 'AvekApetiBackBundle:Categorie',
                'choice_label' => 'name',
                "multiple" => false,
                "expanded" => false
            ))
            ->add('tlivs', 'entity',  array(
                'class' => 'AvekApetiBackBundle:TypeLivraison',
                'choice_label' => 'name',
                "multiple" => false,
                "expanded" => false
            ))
            ->add('image',new ImageType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AvekApeti\BackBundle\Entity\Plat'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'avekapeti_backbundle_plat';
    }
}
