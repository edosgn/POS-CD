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
}