<?php

namespace AvekApeti\GourmetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AvekApeti\BackBundle\Form\Type\TelType;
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
            ->add('email','email')
            ->add('login')
            ->add('password','password')
            ->add('phone',new TelType())
            ->add('newsletter','checkbox', array(
                'attr' => array(
                                'checked' => 'checked'

                )
            ));
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
