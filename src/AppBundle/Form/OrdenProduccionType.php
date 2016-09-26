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
            ->add('destinatarioNombres')
            ->add('destinatarioApellidos')
            ->add('telefono')
            ->add('horario','entity',array(
                'class' => 'AppBundle:Horario',
                'empty_value' => false,
            ))
            ->add('direccionEntrega')
            ->add('descripcionDireccion')
            ->add('zonaEnvio','entity',array(
                'class' => 'AppBundle:ZonaEnvio',
                'empty_value' => false,
            ))
            ->add('numero')
            ->add('tipoPago','choice',array(
                'choices'=>array(
                    'contado'=>'Contado',
                    'credito'=>'Credito',
                    'consignacion'=>'Consignación',
                    'giro'=>'Giro',
                    'tarjeta'=>'Tarjeta'),
                'empty_value'=>false,
            ))
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
