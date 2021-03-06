<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OrdenProduccionDetalleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdenProduccionDetalleRepository extends EntityRepository
{
	//
    public function getOrdenProduccionDetalleTipoResponsable($tipo,$idUsuario = null)
    {
    	if ($idUsuario == null) {
    		$query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('opd.ordenProduccionEstado = :tipo')
	        ->setParameter('tipo', $tipo)
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery(); 
    	}else{
    		$query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('opd.ordenProduccionEstado = :tipo AND opd.responsable = :idUsuario')
	        ->setParameter('idUsuario', $idUsuario)
	        ->setParameter('tipo', $tipo)
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();
    	}

        return $query->getResult();
    }


    //
    public function getOrdenProduccionDetalleTipoUsuario($tipo,$idUsuario = null)
    {
    	if ($idUsuario == null) {
    		$query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('opd.ordenProduccionEstado = :tipo')
	        ->setParameter('tipo', $tipo)
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery(); 
    	}else{
    		$query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('opd.ordenProduccionEstado = :tipo AND p.usuario = :idUsuario')
	        ->setParameter('idUsuario', $idUsuario)
	        ->setParameter('tipo', $tipo)
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();
    	}

        return $query->getResult();
    }


    //
    public function getOrdenProduccionDetalleComercial($idUsuario = null)
    {
    	if ($idUsuario == null) {
	        $query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('opd.ordenProduccionEstado != 5')
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();
	    }else{
	    	$query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('p.usuario = :idUsuario AND opd.ordenProduccionEstado != 5')
	        ->setParameter('idUsuario', $idUsuario)
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();	
	    }

        return $query->getResult();
    }

    
    public function getOrdenProduccionDetalleEntregadaZona($zona,$idUsuario = null)
    {
    	if ($idUsuario == null) {
	        $query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->join('op.zonaEnvio','ze')
	        ->where('opd.ordenProduccionEstado = 3 AND ze.nombre = :nombre_zona AND op.direccionEntrega != :direccion')
	        ->setParameter('nombre_zona', $zona)
	        ->setParameter('direccion', 'Floristeria')
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();
	    }else{
	    	$query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('opd.ordenProduccionEstado = 3 AND opd.responsable = :idUsuario')
	        ->setParameter('idUsuario', $idUsuario)
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();	
	    }

        return $query->getResult();
    }

    //
    public function getOrdenProduccionDetalleProduccionTerminada($idUsuario = null)
    {
    	if ($idUsuario == null) {
	        $query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('opd.ordenProduccionEstado = 2 OR opd.ordenProduccionEstado = 3')
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();
	    }else{
	    	$query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('(opd.ordenProduccionEstado = 2 OR opd.ordenProduccionEstado = 3)
	        AND opd.responsable = :idUsuario')
	        ->setParameter('idUsuario', $idUsuario)
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();	
	    }

        return $query->getResult();
    }

    //
    public function getOrdenProduccionDetalleDespachoEntregada($idUsuario = null)
    {
        if ($idUsuario == null) {
	        $query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('opd.ordenProduccionEstado = 4 OR opd.ordenProduccionEstado = 5')
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();
	    }else{
	    	$query = $this->createQueryBuilder('opd')
	        ->join('opd.ordenProduccion', 'op')
	        ->join('op.pedido', 'p')
	        ->where('(opd.ordenProduccionEstado = 4 OR opd.ordenProduccionEstado = 5)
	        AND opd.responsable = :idUsuario')
	        ->setParameter('idUsuario', $idUsuario)
	        ->orderBy('op.prioridad', 'DESC')
	        ->getQuery();	
	    }

        return $query->getResult();
    }


    //Obtiene las ordenes de produccion con estdo terminado y para entregar en punto de venta
    public function getOrdenesEstadoConDireccion()
    {
        $em = $this->getEntityManager();
        $dql = "SELECT opd
            FROM AppBundle:OrdenProduccionDetalle opd
            JOIN opd.ordenProduccion op
            WHERE opd.ordenProduccionEstado = :estado
            AND op.direccionEntrega = :direccion
            ORDER BY op.prioridad DESC";

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('estado', 3);
        $consulta->setParameter('direccion', 'Floristeria');
        return $consulta->getResult();
    }

    //Obtiene todos los detalles que pertenecen a la orden de produccion q se envia
    public function getDetallesOrdenProduccion($id)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT opd
            FROM AppBundle:OrdenProduccionDetalle opd
            JOIN opd.ordenProduccion op
            WHERE opd.ordenProduccion = :orden";

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('orden', $id);
        return $consulta->getResult();
    }
}
