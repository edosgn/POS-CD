<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\Date;
use AppBundle\Entity\Pedido;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\OrdenProduccion;
use AppBundle\Form\PedidoType;

/**
 * Pedido controller.
 *
 * @Route("/pedido")
 */
class PedidoController extends Controller
{

    /**
     * Lista los clientes para iniciar un nuevo pedido.
     *
     * @Route("/acceso", name="acceso_pedido")
     * @Method("GET")
     */
    public function accesoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clientes = $em->getRepository('AppBundle:Cliente')->findAll();

        return $this->render('pedido/acceso.html.twig', array(
            'clientes' => $clientes,
        ));
    }

    /**
     * Lists all Pedido entities.
     *
     * @Route("/", name="pedido_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pedidos = $em->getRepository('AppBundle:Pedido')->findAll();

        return $this->render('pedido/index.html.twig', array(
            'pedidos' => $pedidos,
        ));
    }

    /**
     * Creates a new Pedido entity.
     *
     * @Route("/new", name="pedido_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pedido = new Pedido();
        $form = $this->createForm('AppBundle\Form\PedidoType', $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $cliente = $form['cliente']->getData();
            if ($cliente) {
                if ($cliente->getTelefono() != $request->request->get('textCelular')) {
                    $cliente->setTelefono($request->request->get('textCelular'));

                    $em->persist($cliente);
                    $em->flush();
                }
                if ($cliente->getTelefonoOpc() != $request->request->get('textTelefono')) {
                    $cliente->setTelefono($request->request->get('textTelefono'));

                    $em->persist($cliente);
                    $em->flush();
                }
                if ($cliente->getCorreo() != $request->request->get('textCorreo')) {
                    $cliente->setCorreo($request->request->get('textCorreo'));

                    $em->persist($cliente);
                    $em->flush();
                }
            }

            $em->persist($pedido);
            $em->flush();

            return $this->redirectToRoute('orden_produccion_new', array('idPedido' => $pedido->getId()));
        }

        $em = $this->getDoctrine()->getManager();
        $idCliente=$request->query->get('idCliente');
        //var_dump($idCliente);
        //die();
        $cliente= $em->getRepository('AppBundle:Cliente')->find($idCliente);

        $consecutivo= $em->getRepository('AppBundle:Pedido')->findConsecutivo(date('Y'));
        $consecutivo = str_pad($consecutivo['maximo'], 3, "0", STR_PAD_LEFT);
        $numero= "P".date('Y').date('m')."-".$consecutivo;

        return $this->render('pedido/new.html.twig', array(
            'pedido' => $pedido,
            'cliente' => $cliente,
            'numero' => $numero,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pedido entity.
     *
     * @Route("/{id}", name="pedido_show")
     * @Method("GET")
     */
    public function showAction(Pedido $pedido)
    {
        $deleteForm = $this->createDeleteForm($pedido);
        $em = $this->getDoctrine()->getManager();
        $ordenes=$em->getRepository("AppBundle:OrdenProduccion")->findBy(array('pedido'=>$pedido->getId()));
        $ventas=$em->getRepository("AppBundle:Venta")->findBy(array('pedido'=>$pedido->getId()));
        
        return $this->render('pedido/show.html.twig', array(
            'pedido' => $pedido,
            'ordenes' => $ordenes,
            'ventas' => $ventas,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pedido entity.
     *
     * @Route("/{id}/edit", name="pedido_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pedido $pedido)
    {
        $deleteForm = $this->createDeleteForm($pedido);
        $editForm = $this->createForm('AppBundle\Form\PedidoType', $pedido);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pedido->setUpdatedAt();
            
            $em->persist($pedido);
            $em->flush();

            return $this->redirectToRoute('pedido_show', array('id' => $pedido->getId()));
        }

        return $this->render('pedido/edit.html.twig', array(
            'pedido' => $pedido,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pedido entity.
     *
     * @Route("/{id}", name="pedido_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pedido $pedido)
    {
        $form = $this->createDeleteForm($pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pedido);
            $em->flush();
        }

        return $this->redirectToRoute('pedido_index');
    }

    /**
     * Creates a form to delete a Pedido entity.
     *
     * @param Pedido $pedido The Pedido entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pedido $pedido)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedido_delete', array('id' => $pedido->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * valida si el cliente ya ha tenido credito para no volver a pedir PIN a administrador.
     *
     * @Route("/valida/credito", name="orden_produccion_valida_credito")
     * @Method("GET")
     */
    public function validaCreditoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $creditos=$em->getRepository('AppBundle:Pedido')->findPedidoCredito($request->query->get('idCliente'));

        $ban = false;
        if (count($creditos) != 0) {
            $ban = true;
        }

        $response = new JsonResponse();

        $entidades = array();
        $entidades[] = array(
            'ban'=>$ban,
        );

        $response->setData($entidades);

        return $response;
    } 

    /**
     * setea el metodo de pago del pedido.
     *
     * @Route("/metodo/pago", name="metodo_pago")
     * @Method("GET")
     */
    public function metodoPagoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pedido=$em->getRepository('AppBundle:Pedido')->find($request->query->get('id'));        

        $response = new JsonResponse();

        $entidades = array();
        $entidades[] = array(
            'ban'=>$ban,
        );

        $response->setData($entidades);

        return $response;
    }


    /**
     * guarda el estado de la opcion seleccionada en el pedido (porpagar,porcobrar,pendiente).
     *
     * @Route("/estado/pedido/{id}/{estado}", name="estado_pedido")
     * @Method("GET")
     */
    public function estadoPedidoAction($id,$estado)
    {
        $em = $this->getDoctrine()->getManager();
        $pedido=$em->getRepository('AppBundle:Pedido')->find($id);        
        $pedido->setEstado($estado);
        
        $em->persist($pedido);
        $em->flush();

        return $this->redirectToRoute('pedido_show',array(
            'id'=>$pedido->getId()
        ));
    }
}
