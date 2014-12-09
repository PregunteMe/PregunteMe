<?php

namespace PregunteMe\AdministracionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'text', array('label' => 'Usuario'))
            ->add('pass', 'repeated', array(
						'type' => 'password',
						'invalid_message' => 'Las claves deben ser iguales.',
						'options' => array('attr' => array('class' => 'password-field')),
						'required' => true,
						'first_options' => array('label' => 'Clave'),
						'second_options' => array('label' => 'Repita la clave')
					)
				)
            ->add('email', 'email', array('label' => 'Correo'))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PregunteMe\AdministracionBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pregunteme_administracionbundle_usuario';
    }
}
