<?php

namespace PregunteMe\AdministracionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreguntaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('texto')
            ->add('puntajeMin')
            ->add('evaluador')
            ->add('cardinal')
            ->add('nivel')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PregunteMe\AdministracionBundle\Entity\Pregunta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pregunteme_administracionbundle_pregunta';
    }
}
