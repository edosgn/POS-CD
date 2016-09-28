<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('identificacion')     
            ->add('nombre')
            ->add('apellido')
            ->add('telefono')
            ->add('telefonoOpc')
            ->add('correo')
            ->add('preferencias')
            ->add('tipo','choice',array(
                'choices' => array(
                    'natural' => 'Persona Natural',
                    'juridica' => 'Persona Juridica'
                ),
                'empty_value' => 'Seleccione un tipo'
            ))

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cliente'
        ));
    }
}
