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
 * @Route("/despacho")
 */
class DespachoController extends Controller
{
    /**
     * añade una novedad a la orden del porq no fue recibida a satisfaccion
     *
     * @Route("/entrega", name="despacho_entrega")
     * @Method("POST")
     */
    public function entregaAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            
            $em = $this->getDoctrine()->getManager();

            $ordenProduccionDetalle = $em->getRepository('AppBundle:OrdenProduccionDetalle')->find($request->request->get('idOrdenProduccionDetalle'));
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

            //Revisar consulta para que muestre siguiente y validar que no actualiza el estado del detalle

            $despachoNew=$em->getRepository('AppBundle:Despacho')->findOneBy(
                array(),
                array(
                    'fechaEntrega'=>'DESC'
                )
            );

            if ($despachoNew) {
                return $this->redirectToRoute('orden_produccion_detalle_show', array(
                    'id' => $despachoNew->getOrdenProduccionDetalle()->getId()
                ));
            }
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * Lista las ordenes de produccion listas para entregar.
     *
     * @Route("/", name="despacho_list")
     * @Method("GET")
     */
    public function listarAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $ordenes = $em->getRepository('AppBundle:OrdenProduccion')->findByEstado('Listo');

        return $this->render('despacho/list.html.twig', array(
            'ordenes' => $ordenes,
        ));
    }

    /**
     * cambia el estado a en camino de la orden y lista las ordenes con su estado.
     *
     * @Route("/{orden}/estado/{estado}", name="despacho_estado")
     * @Method("GET")
     */
    public function estadoAction($orden,$estado)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenProduccion=$em->getRepository('AppBundle:OrdenProduccion')->findOneById($orden);
        $ordenProduccion->setEstado($estado);
        $em->persist($ordenProduccion);
        $em->flush();

        $ordenes = $em->getRepository('AppBundle:OrdenProduccion')->findByEstado('Listo');

        return $this->render('despacho/list.html.twig', array(
            'ordenes' => $ordenes,
        ));
    }

    /**
     * añade una novedad a la orden del porq no fue recibida a satisfaccion
     *
     * @Route("/novedad/{id}", name="despacho_novedad")
     * @Method({"GET", "POST"})
     */
    public function novedadAction(OrdenProduccion $ordenProduccion)
    {
        $form=$this->createFormBuilder()
            ->add('novedad','text')
            ->getForm();

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ordenProduccion);
            $em->flush();

            return $this->redirectToRoute('despacho_list');
        }

        return $this->render('despacho/novedad.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Lista las ordenes que estan en camino.
     *
     * @Route("/camino", name="despacho_camino")
     * @Method("GET")
     */
    public function caminoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ordenes = $em->getRepository('AppBundle:OrdenProduccion')->findByEstado('En Camino');

        return $this->render('despacho/camino.html.twig', array(
            'ordenes' => $ordenes,
        ));
    }

    /**
     * Lista las ordenes que fueron entregadas.
     *
     * @Route("/entregadas", name="despacho_entregadas")
     * @Method("GET")
     */
    public function entregadaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ordenes = $em->getRepository('AppBundle:OrdenProduccion')->findByEstado('Entregado');

        return $this->render('despacho/entregadas.html.twig', array(
            'ordenes' => $ordenes,
        ));
    }
}