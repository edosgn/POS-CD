<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function getChoices(){
        $choices = array();
        for($i = 1; $i <= 12; $i++){
            $choices[$i] = $i;
        }

        return $choices;
    }
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jornada','choice',array(
                'choices' => array(
                    'AM' => 'AM',
                    'PM' => 'PM'
                ),
                'empty_value' => false
            ))
            ->add('inicio','choice',array(
                'choices' => $this->getChoices(),
                'empty_value' => false
            ))
            ->add('final','choice',array(
                'choices' => $this->getChoices(),
                'empty_value' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Horario'
        ));
    }
}
