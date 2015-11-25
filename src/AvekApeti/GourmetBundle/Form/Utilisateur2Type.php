<?php

namespace AvekApeti\GourmetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Avekapeti\BackBundle\Form\ImageType;
class Utilisateur2Type extends AbstractType
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
            ->add('newsletter')
            ->add('image', new ImageType(), [
                "required" => false,
            ])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Avekapeti\BackBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'avekapeti_gourmetbundle_utilisateur';
    }
}
