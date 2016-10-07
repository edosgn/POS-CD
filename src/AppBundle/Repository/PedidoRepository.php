<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PedidoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PedidoRepository extends EntityRepository
{
	//Obtiene numero maximo para consecutivo pedido
    public function findConsecutivo($anio)
    {
        $em = $this->getEntityManager();
        $dql = 'SELECT COUNT(p.id) + 1 AS maximo
            FROM AppBundle:Pedido p
            WHERE YEAR(p.createdAt) = :anio';
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('anio', $anio);
        return $consulta->getOneOrNullResult();
    }

	public function findPedidosByUsuario($user){
		$em=$this->getEntityManager();
		$dql='SELECT p,o
			  FROM AppBundle:OrdenProduccion o
			  JOIN o.pedido p
			  WHERE p.usuario = :usuario			  
			  ORDER BY o.fechaEntrega ASC';

		$consulta=$em->createQuery($dql);
		$consulta->setParameter('usuario',$user);

		return $consulta->getResult();
	}

	public function findOrdenesByUsuario($user){
		$em=$this->getEntityManager();
		$dql='SELECT p,o
		      FROM AppBundle:OrdenProduccion o
		      JOIN o.pedido p
		      WHERE o.responsableProduccion = :usuario		      
		      ORDER BY o.fechaEntrega ASC';
		$consulta=$em->createQuery($dql);
		$consulta->setParameter('usuario',$user);

		return $consulta->getResult();
	}

	public function findByFinalizadas($usuario,$estado){
		$em=$this->getEntityManager();
		$dql='SELECT p,o
		      FROM AppBundle:OrdenProduccion o
		      JOIN o.pedido p
		      WHERE o.responsableProduccion = :usuario
		      AND o.estado = :estado
		      ORDER BY o.fechaEntrega ASC';

		$consulta=$em->createQuery($dql);		
		$consulta->setParameter('usuario', $usuario);
		$consulta->setParameter('estado',$estado);

		return $consulta->getResult();
	}

	//Obtiene los pedidos de un cliente q sean de tipo credito
    public function findPedidoCredito($idCliente)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT p
            FROM AppBundle:Pedido p            
            WHERE p.cliente = :idCliente
            AND p.estado = :tipo";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('idCliente', $idCliente);
        $consulta->setParameter('tipo', 'PorPagar');
        return $consulta->getResult();
    }
}
