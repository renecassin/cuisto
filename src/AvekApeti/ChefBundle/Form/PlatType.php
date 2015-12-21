<?php

namespace AvekApeti\ChefBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AvekApeti\BackBundle\Form\ImageType;

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
            ->add('quantity', null, array('attr' => array('min' =>0)))
            ->add('active')
            ->add('unableWhile')
            ->add('dateStart')
            ->add('dateEnd')
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
            ->add('tcoms', 'entity',  array(
                'class' => 'AvekApetiBackBundle:TypeCommande',
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
            ->add('image',new ImageType(), array('required' => false))
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
