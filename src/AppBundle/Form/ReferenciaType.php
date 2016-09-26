<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferenciaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identificacion')
            ->add('nombres')
            ->add('apellidos')
            ->add('parentesco','entity',array(
                'class' => 'AppBundle:Parentesco',
                'empty_value' => false,
            ))            
            ->add('telefono')
            ->add('direccion')
            ->add('correo')
            ->add('descripcionFecha','choice', array(
                'choices'=> array('aniversario'=>'Aniversario', 'cumpleaños'=>'Cumpleaños'),
                'empty_value'=>false,
            ))
            ->add('intereses','text') 
            ->add('cliente')           
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Referencia'
        ));
    }
}
