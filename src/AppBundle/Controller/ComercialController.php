<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Pedido;
use AppBundle\Entity\OrdenProduccion;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Despacho;

/**
 * Produccion controller.
 *
 * @Route("/comercial")
 */
class ComercialController extends Controller
{
    /**
     * Lists las ordenes de produccion creadas por usuario.
     *
     * @Route("/{user}", name="comercial_list")
     * @Method("GET")
     */
    public function listarAction(Usuario $user)
    {
        $em = $this->getDoctrine()->getManager();

        $ordenes = $em->getRepository('AppBundle:Pedido')->findPedidosByUsuario($user);

        return $this->render('comercial/list.html.twig', array(
            'ordenes' => $ordenes,
        ));
    }

    /**
     * Lists las ordenes de produccion listas para entregar en punto de venta.
     *
     * @Route("/entrega", name="comercial_entrega")
     * @Method("GET")
     */
    public function entregaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ordenes = $em->getRepository('AppBundle:OrdenProduccion')->findByEstado('Listo');

        return $this->render('comercial/entrega.html.twig', array(
            'ordenes' => $ordenes,
        ));
    }

    /**
     * validar si el cliente existe para añadir un nuevo pedido
     *
     * @Route("/valida/cliente", name="comercial_valida_cliente")
     * @Method("POST")
     */
    public function validaClienteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cliente=$em->getRepository('AppBundle:Cliente')->findOneByIdentificacion($request->request->get('textIdentificacion'));

        //var_dump($cliente->getNombre());
        //die();
        $ban = false;
        $idCliente=null;
        $nombre=null;
        $ced=null;
        if (count($cliente) != 0) {
            $ban = true;
            $idCliente=$cliente->getId();
            $nombre=$cliente->__toString();
            $ced=$cliente->getIdentificacion();
        }

        $response = new JsonResponse();

        $entidades = array();
        $entidades[] = array(
            'ban'=>$ban,
            'idCliente'=>$idCliente,
            'named'=>$nombre,
            'ced'=>$ced
        );

        $response->setData($entidades);

        return $response;
    }



    /**
     * añade una novedad a la orden entregada en punto de venta
     *
     * @Route("/entrega/comercial", name="comercial_entrega")
     * @Method("POST")
     */
    public function entregaComercialAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {            
            $em = $this->getDoctrine()->getManager();

            //---almacenar el registro en despacho
            $user = $this->getUser();
            $despacho = new Despacho();
            $ordenProduccionDetalle = $em->getRepository('AppBundle:OrdenProduccionDetalle')->find($request->request->get('idOrdenProduccionDetalle'));
            $ordenProduccionEstado = $em->getRepository('AppBundle:OrdenProduccionEstado')->find(4);
            $ordenProduccionDetalle->setOrdenProduccionEstado($ordenProduccionEstado);
            $em->persist($ordenProduccionDetalle);
            $despacho->setUsuario($user);
            $despacho->setOrdenProduccionDetalle($ordenProduccionDetalle);

            $em->persist($despacho);
            $em->flush();
            //--

            
            $ordenProduccionEstado = $em->getRepository('AppBundle:OrdenProduccionEstado')->find($request->request->get('textEstado'));
            $ordenProduccionDetalle->setOrdenProduccionEstado($ordenProduccionEstado);

            $despacho=$em->getRepository('AppBundle:Despacho')->findOneByOrdenProduccionDetalle(
                $request->request->get('idOrdenProduccionDetalle')
            );

            $despacho->setFechaEntrega(new \DateTime(date('Y-m-d H:i:s')));
            $despacho->setReceptor($request->request->get('textReceptor'));

            if ($request->request->get('textObservaciones') != '') {
                $despacho->setObservaciones($request->request->get('textObservaciones'));
            }

            $em->persist($despacho);
            $em->persist($ordenProduccionDetalle);
            $em->flush();

            $ordenesEntregarPuntoVenta = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenesEstadoConDireccion();
        
            return $this->render('comercial/entregar.comercial.html.twig', array(
                'ordenesProduccionDetalleEntregar' => $ordenesEntregarPuntoVenta,
            ));
        }

        return $this->redirectToRoute('homepage');
    }    
}