<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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
}