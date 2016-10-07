<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class OrdenProduccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pedido')
            ->add('horario','entity',array(
                'class' => 'AppBundle:Horario',
                'empty_value' => false,
            ))
            ->add('numero')            
            ->add('prioridad','entity',array(
                'class' => 'AppBundle:Prioridad',
                'query_builder' => function(EntityRepository $em){
                    $qb = $em->createQueryBuilder('p');
                    $qb->where($qb->expr()->orX($qb->expr()->eq('p.nombre', ':normal'), $qb->expr()->eq('p.nombre', ':important')));
                    $qb->setParameter('normal', 'Normal');
                    $qb->setParameter('important', 'Importante');
                    return $qb;
                },
                'empty_value' => false,
            ))
            ->add('detalle')
            ->add('mensaje')
            ->add('descripcionMensaje','textarea',array(
                'attr' => array('rows' => '5')
            ))
            ->add('responsable','entity',array(
                'class' => 'AppBundle:Usuario',
                'query_builder' => function(EntityRepository $em){
                    $qb = $em->createQueryBuilder('u');
                    $qb->add('where', $qb->expr()->like('u.role', ':rol'));
                    $qb->setParameter('rol', '%PRODUCTION%');
                    return $qb;
                },
                'empty_value' => false,
            ))
            ->add('precio')
            ->add('valorEnvio')
            ->add('observacion')
            ->add('firma')
            ->add('ordenProduccionEstado','entity',array(
                'class' => 'AppBundle:OrdenProduccionEstado',
                'query_builder' => function(EntityRepository $em){
                    $qb = $em->createQueryBuilder('e');
                    $qb->add('where', $qb->expr()->eq('e.estado', ':estate'));
                    $qb->setParameter('estate', 1);
                    return $qb;
                },
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
            'data_class' => 'AppBundle\Entity\OrdenProduccion'
        ));
    }
}
