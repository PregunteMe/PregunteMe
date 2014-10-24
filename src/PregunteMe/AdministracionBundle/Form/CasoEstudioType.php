<?php

namespace PregunteMe\AdministracionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CasoEstudioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('institucion')
            ->add('programa')
            ->add('nombre')
            ->add('correo')
            ->add('fecha')
            ->add('nombreObjeto')
            ->add('respuestas')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PregunteMe\AdministracionBundle\Entity\CasoEstudio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pregunteme_administracionbundle_casoestudio';
    }
}
