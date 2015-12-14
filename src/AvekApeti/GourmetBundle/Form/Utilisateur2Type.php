<?php

namespace AvekApeti\GourmetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AvekApeti\BackBundle\Form\ImageType;
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
            ->add('email','email')
            ->add('login')
            ->add('password','password',[
            "required" => false,
            ])
            ->add('adress')
            ->add('city')
            ->add('cp')
            ->add('phone')
            /*
            ->add('newsletter',null,[
                "required" => false,
            ])
            ->add('image', new ImageType(), [
                "required" => false,
            ])
            A REMETTRE : Newsletter + Image */

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
