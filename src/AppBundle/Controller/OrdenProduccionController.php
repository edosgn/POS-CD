<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OrdenProduccion;
use AppBundle\Entity\Pedido;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\OrdenProduccionDetalle;
use AppBundle\Form\OrdenProduccionType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * OrdenProduccion controller.
 *
 * @Route("/orden_produccion")
 */
class OrdenProduccionController extends Controller
{
    /**
     * Lists all OrdenProduccion entities.
     *
     * @Route("/", name="orden_produccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ordenProduccions = $em->getRepository('AppBundle:OrdenProduccion')->findAll();

        return $this->render('ordenproduccion/index.html.twig', array(
            'ordenProduccions' => $ordenProduccions,
        ));
    }

    /**
     * Creates a new OrdenProduccion entity.
     *
     * @Route("/new", name="orden_produccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ordenProduccion = new OrdenProduccion();
        $form = $this->createForm('AppBundle\Form\OrdenProduccionType', $ordenProduccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();


            $ordenProduccion->setFechaEntrega(new \DateTime($request->request->get('fechaEntrega')));

            
            $dia = new \DateTime($request->request->get('fechaEntrega'));
            $consecutivo= $em->getRepository('AppBundle:OrdenProduccion')->findConsecutivo(date('Y'));
            $consecutivo = str_pad($consecutivo['maximo'], 3, "0", STR_PAD_LEFT);
            $numero= "OP".date('Y').$dia->format('d')."-".$consecutivo;

            $ordenProduccion->setNumero($numero);

            $em->persist($ordenProduccion);
            $em->flush();

            return $this->redirectToRoute('orden_produccion_edit', array(
                'id' => $ordenProduccion->getId(),
            ));
        }

        $em = $this->getDoctrine()->getManager();
 
        $pedido= $em->getRepository('AppBundle:Pedido')->find($request->query->get('idPedido'));

        return $this->render('ordenproduccion/new.html.twig', array(
            'ordenProduccion' => $ordenProduccion,
            'pedido' => $pedido,
            'step' => $request->query->get('idStep'),      
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrdenProduccion entity.
     *
     * @Route("/{id}", name="orden_produccion_show")
     * @Method("GET")
     */
    public function showAction(OrdenProduccion $ordenProduccion)
    {
        $deleteForm = $this->createDeleteForm($ordenProduccion);
        $pedido=$ordenProduccion->getPedido(); 


        $hora = $ordenProduccion->getHorario()->getInicio();
        $jornada = $ordenProduccion->getHorario()->getJornada();
        $fecha = $ordenProduccion->getFechaEntrega()->format('Y-m-d H:i:s');

        if($jornada == 'PM') {
            $hora = $hora + 12 ;
        }

        $nuevafecha = strtotime ( '+'.$hora.' hour' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j H:i:s' , $nuevafecha );

        $fecha1 = new \DateTime($nuevafecha);

        //VERIFICAR SI TODAS LOS DETALLES DE LA ORDEN ESTAN terminadas
        $em = $this->getDoctrine()->getManager();
        $detallesOrdenProduccion = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getDetallesOrdenProduccion($ordenProduccion->getId());
        $c=0;
        foreach ($detallesOrdenProduccion as $ordenProduccionDetalle) {
            if ($ordenProduccionDetalle->getOrdenProduccionEstado()->getId() == 3) {
                $c=$c+1;
            }
        }
        if ($c == count($detallesOrdenProduccion)) {            
            $ordenProduccion->setEstado("Terminada");
            $em->persist($ordenProduccion);
            $em->flush();
        }
        //----

        return $this->render('ordenproduccion/show.html.twig', array(
            'nuevafecha' => $fecha1,
            'ordenProduccion' => $ordenProduccion,
            'pedido' => $pedido,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrdenProduccion entity.
     *
     * @Route("/{id}/edit", name="orden_produccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OrdenProduccion $ordenProduccion)
    {
        $deleteForm = $this->createDeleteForm($ordenProduccion);
        $editForm = $this->createForm('AppBundle\Form\OrdenProduccionType', $ordenProduccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($ordenProduccion);
            $em->flush();
            return $this->redirectToRoute('orden_produccion_show', array('id' => $ordenProduccion->getId()));            
        }

        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')->findByRole('ROLE_ADMIN');

        return $this->render('ordenproduccion/edit.html.twig', array(
            'ordenProduccion' => $ordenProduccion,
            'usuarios' => $usuarios,
            'step' => $request->query->get('idStep'),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'error' => null,
        ));
    }

    /**
     * Deletes a OrdenProduccion entity.
     *
     * @Route("{id}", name="orden_produccion_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, OrdenProduccion $ordenProduccion)
    {
        
        




    }

    /**
     * Creates a form to delete a OrdenProduccion entity.
     *
     * @param OrdenProduccion $ordenProduccion The OrdenProduccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrdenProduccion $ordenProduccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orden_produccion_delete', array('id' => $ordenProduccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * cambia el estado de pendiente a asignada la orden para q sea visible desde produccion.
     *
     * @Route("/asignar/{id}", name="orden_produccion_asignar")
     * @Method("GET")
     */
    public function asignarAction(OrdenProduccion $ordenProduccion)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenProduccion->setEstado('Asignada');
        $em->persist($ordenProduccion);
        $em->flush();       

        return $this->render('ordenproduccion/show.html.twig', array(
            'ordenProduccion' => $ordenProduccion,
        ));
    }

    /**
     * valida la identificacion y el PIN si el pago es a credito o con prioridad importante.
     *
     * @Route("/valida/pago", name="orden_produccion_valida_pago")
     * @Method("POST")
     */
    public function validaPagoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $id= $request->request->get('selectAdmin');
        $pin= $request->request->get('textPin');
        $ban=false;
        if($usuario=$em->getRepository('AppBundle:Usuario')->find($id)){
            $pinuser=$usuario->getPin();

            if($pinuser == $pin){
                $ban=true;
            }else{
                $ban=false;
            }
        }

        $response = new JsonResponse();

        $entidades = array();
        $entidades[] = array(
            'ban'=>$ban, 
        );

        $response->setData($entidades);

        return $response;
    }   
}
