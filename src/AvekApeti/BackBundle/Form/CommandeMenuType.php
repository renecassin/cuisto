<?php
namespace AvekApeti\BackBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class CommandeMenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('menu', 'entity',
                [
                    'class' => 'AvekApetiBackBundle:Menu',
                    'property' => 'name',
                ])
        ;
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AvekApeti\BackBundle\Entity\CommandeMenu'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'avekapeti_backbundle_commande_menu';
    }
}