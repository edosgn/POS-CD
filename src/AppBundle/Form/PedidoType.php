<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class PedidoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario','entity',array(
                'class' => 'AppBundle:Usuario',
                'query_builder' => function(EntityRepository $em){
                    $qb = $em->createQueryBuilder('u');
                    $qb->add('where', $qb->expr()->like('u.role', ':rol'));
                    $qb->setParameter('rol', '%COMMERCIAL%');
                    return $qb;
                },
                'empty_value' => false,
            ))
            ->add('cliente','entity',array(
                'class' => 'AppBundle:Cliente',
                'empty_value' => false,
            ))
            ->add('numero')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pedido'
        ));
    }
}
