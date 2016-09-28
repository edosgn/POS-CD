<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
    	$usuario = $this->get('security.token_storage')->getToken()->getUser();
    	$em = $this->getDoctrine()->getManager();

    	switch ($usuario->getRole()) {
    		case 'ROLE_ADMIN':
                $pedidos = $em->getRepository('AppBundle:Pedido')->findBy(
                    array(
                        'usuario' => $usuario->getId(),
                    )
                );

                $ordenProduccionDetalleAsignada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleAsignada();

                $ordenProduccionDetalleProduccionTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleProduccionTerminada();

                $ordenProduccionDetalleDespachoEntregada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleDespachoEntregada();

    			return $this->render('default/index.html.twig', array(
                    'pedidos' => $pedidos,
                    'ordenProduccionDetalleAsignada' => $ordenProduccionDetalleAsignada,
                    'ordenProduccionDetalleProduccionTerminada' => $ordenProduccionDetalleProduccionTerminada,
                    'ordenProduccionDetalleDespachoEntregada' => $ordenProduccionDetalleDespachoEntregada,
                ));
    			break;
    		case 'ROLE_COMMERCIAL':
    			$pedidos = $em->getRepository('AppBundle:Pedido')->findBy(
    				array(
    					'usuario' => $usuario->getId(),
    				)
    			);

                $ordenProduccionDetalleProduccion = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleProduccion(
                    $usuario->getId()
                );

                $ordenProduccionDetalleTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTerminada(
                    $usuario->getId()
                );

                $ordenProduccionDetalleEntregada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregada($usuario->getId()
                );

                return $this->render('default/index.commercial.html.twig', array(
                    'pedidos' => $pedidos,
                    'ordenProduccionDetalleProduccion' => $ordenProduccionDetalleProduccion,
                    'ordenProduccionDetalleTerminada' => $ordenProduccionDetalleTerminada,
                    'ordenProduccionDetalleEntregada' => $ordenProduccionDetalleEntregada,
                ));
    			break;
    		case 'ROLE_PRODUCTION':
                $ordenProduccionDetalleAsignada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleAsignada($usuario->getId()
                );

                $ordenProduccionDetalleProduccion = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleProduccion(
                    $usuario->getId()
                );

                $ordenProduccionDetalleTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTerminada(
                    $usuario->getId()
                );

                return $this->render('default/index.production.html.twig', array(
                    'ordenProduccionDetalleAsignada' => $ordenProduccionDetalleAsignada,
                    'ordenProduccionDetalleProduccion' => $ordenProduccionDetalleProduccion,
                    'ordenProduccionDetalleTerminada' => $ordenProduccionDetalleTerminada,
                ));
    			break;
    		case 'ROLE_SHIPPING':
    			
                $ordenProduccionDetalleEntregada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregada();

                $getOrdenProduccionDetalleEntregadaZonaNorte = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregadaZona("Norte");

                $OrdenProduccionDetalleEntregadaZonaSur = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregadaZona("Sur");

                $OrdenProduccionDetalleEntregadaZonaPeriferico = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregadaZona("Periferico");

                $OrdenProduccionDetalleEntregadaZonaEste = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregadaZona("Este");

                $OrdenProduccionDetalleEntregadaZonaOeste = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregadaZona("Oeste");

                $OrdenProduccionDetalleEntregadaZonaCentro = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregadaZona("Centro");



                foreach ($OrdenProduccionDetalleEntregadaZonaSur as $array) {
                    var_dump($array->getOrdenProduccion()->getZonaEnvio()->getNombre()) ;
                }
                //die();

                $ordenProduccionDetalleDespacho = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleDespacho();


                $ordenProduccionDetalleTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTerminada();

           

                return $this->render('default/index.shipping.html.twig', array(
                    'OrdenProduccionDetalleEntregadaZonaCentro' => $OrdenProduccionDetalleEntregadaZonaCentro,
                    'OrdenProduccionDetalleEntregadaZonaOeste' => $OrdenProduccionDetalleEntregadaZonaOeste,
                    'OrdenProduccionDetalleEntregadaZonaEste' => $OrdenProduccionDetalleEntregadaZonaEste,
                    'OrdenProduccionDetalleEntregadaZonaPeriferico' => $OrdenProduccionDetalleEntregadaZonaPeriferico,
                    'OrdenProduccionDetalleEntregadaZonaSur' => $OrdenProduccionDetalleEntregadaZonaSur,
                    'getOrdenProduccionDetalleEntregadaZonaNorte'=>$getOrdenProduccionDetalleEntregadaZonaNorte, 
                    'ordenProduccionDetalleEntregada' => $ordenProduccionDetalleEntregada,
                    'ordenProduccionDetalleDespacho' => $ordenProduccionDetalleDespacho,
                    'ordenProduccionDetalleTerminada' => $ordenProduccionDetalleTerminada,
                ));
    			break;
    		default:
    			break;
    	}       
    }
}
