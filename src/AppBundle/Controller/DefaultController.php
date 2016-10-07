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

                $ordenProduccionDetalleAsignada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoUsuario($usuario->getId());

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
    			$ordenProduccionDetalles = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleComercial($usuario->getId());

                $ordenProduccionDetalleProduccion = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoUsuario(
                    2,$usuario->getId()
                );

                $ordenProduccionDetalleTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoUsuario(
                    3,$usuario->getId()
                );

                $ordenProduccionDetalleEntregada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoUsuario(
                    5,$usuario->getId()
                );

                return $this->render('default/index.commercial.html.twig', array(
                    'ordenProduccionDetalles' => $ordenProduccionDetalles,
                    'ordenProduccionDetalleProduccion' => $ordenProduccionDetalleProduccion,
                    'ordenProduccionDetalleTerminada' => $ordenProduccionDetalleTerminada,
                    'ordenProduccionDetalleEntregada' => $ordenProduccionDetalleEntregada,
                ));
    			break;
            case 'ROLE_SELLER':
                $ordenProduccionDetalles = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleComercial($usuario->getId());

                $ordenProduccionDetalleProduccion = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoUsuario(
                    2,$usuario->getId()
                );

                $ordenProduccionDetalleTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoUsuario(
                    3,$usuario->getId()
                );

                $ordenProduccionDetalleEntregada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoUsuario(
                    5,$usuario->getId()
                );

                return $this->render('default/index.commercial.html.twig', array(
                    'ordenProduccionDetalles' => $ordenProduccionDetalles,
                    'ordenProduccionDetalleProduccion' => $ordenProduccionDetalleProduccion,
                    'ordenProduccionDetalleTerminada' => $ordenProduccionDetalleTerminada,
                    'ordenProduccionDetalleEntregada' => $ordenProduccionDetalleEntregada,
                ));
                break;
    		case 'ROLE_PRODUCTION':
                $ordenProduccionDetalleAsignada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoResponsable(
                    1,$usuario->getId()
                );

                $ordenProduccionDetalleProduccion = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoResponsable(
                    2,$usuario->getId()
                );

                $ordenProduccionDetalleTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoResponsable(
                    3,$usuario->getId()
                );

                return $this->render('default/index.production.html.twig', array(
                    'ordenProduccionDetalleAsignada' => $ordenProduccionDetalleAsignada,
                    'ordenProduccionDetalleProduccion' => $ordenProduccionDetalleProduccion,
                    'ordenProduccionDetalleTerminada' => $ordenProduccionDetalleTerminada,
                ));
    			break;
    		case 'ROLE_SHIPPING':
    			
                $ordenProduccionDetalleEntregada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoResponsable(5);
                $ordenProduccionDetalleEntregadaNovedad = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoResponsable(6);

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

                $ordenProduccionDetalleDespacho = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoResponsable(4);


                $ordenProduccionDetalleTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTipoResponsable(3);

           

                return $this->render('default/index.shipping.html.twig', array(
                    'OrdenProduccionDetalleEntregadaZonaCentro' => $OrdenProduccionDetalleEntregadaZonaCentro,
                    'OrdenProduccionDetalleEntregadaZonaOeste' => $OrdenProduccionDetalleEntregadaZonaOeste,
                    'OrdenProduccionDetalleEntregadaZonaEste' => $OrdenProduccionDetalleEntregadaZonaEste,
                    'OrdenProduccionDetalleEntregadaZonaPeriferico' => $OrdenProduccionDetalleEntregadaZonaPeriferico,
                    'OrdenProduccionDetalleEntregadaZonaSur' => $OrdenProduccionDetalleEntregadaZonaSur,
                    'OrdenProduccionDetalleEntregadaZonaNorte'=>$getOrdenProduccionDetalleEntregadaZonaNorte, 
                    'ordenProduccionDetalleEntregada' => $ordenProduccionDetalleEntregada,
                    'ordenProduccionDetalleEntregadaNovedad' => $ordenProduccionDetalleEntregadaNovedad,
                    'ordenProduccionDetalleDespacho' => $ordenProduccionDetalleDespacho,
                    'ordenProduccionDetalleTerminada' => $ordenProduccionDetalleTerminada,
                ));
    			break;
    		default:
    			break;
    	}       
    }
}
