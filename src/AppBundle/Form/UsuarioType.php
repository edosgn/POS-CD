<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('identificacion')
            ->add('telefono')
            ->add('correo')
            ->add('estado', 'choice', array(
                'choices'=> array('1'=>'Activo', '0'=>'Inactivo'),
                'empty_value'=>false,
            ))
            ->add('role','choice',array(
                'choices' => array(
                    'ROLE_ADMIN' => 'Administrador', 
                    'ROLE_COMMERCIAL' => 'Comercial', 
                    'ROLE_PRODUCTION' => 'Produccion', 
                    'ROLE_SHIPPING' => 'Despacho'
                ),
                'empty_value' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }
}
