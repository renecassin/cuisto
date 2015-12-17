<?php
namespace AvekApeti\BackBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class CommandePlatType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plat', 'entity',
                [
                    'class' => 'AvekApetiBackBundle:Plat',
                    'property' => 'name',
                ])
            ->add('quantity')
        ;
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AvekApeti\BackBundle\Entity\CommandePlat'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'avekapeti_backbundle_commande_plat';
    }
}