<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OrdenProduccionDetalle;
use AppBundle\Entity\OrdenProduccionEstado;
use AppBundle\Entity\Despacho;
use AppBundle\Form\OrdenProduccionDetalleType;

/**
 * OrdenProduccionDetalle controller.
 *
 * @Route("/orden_produccion_detalle")
 */
class OrdenProduccionDetalleController extends Controller
{
    /**
     * Change state OrdenProduccionDetalle entities.
     *
     * @Route("/state", name="orden_produccion_detalle_state")
     * @Method("GET")
     */
    public function stateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ordenProduccionDetalle = $em->getRepository('AppBundle:OrdenProduccionDetalle')->find($request->query->get('id'));

        $ordenProduccionEstado = $em->getRepository('AppBundle:OrdenProduccionEstado')->find($request->query->get('idEstado'));

        $ordenProduccionDetalle->setOrdenProduccionEstado($ordenProduccionEstado);

        $em->persist($ordenProduccionDetalle);
        $em->flush();

        return $this->redirectToRoute('orden_produccion_detalle_show',array(
            'id' => $request->query->get('id'),
        ));
    }

   

    /**
     * Lists all OrdenProduccionDetalle entities.
     *
     * @Route("/list", name="orden_produccion_detalle_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ordenProduccion = $em->getRepository('AppBundle:OrdenProduccion')->find($request->query->get('idOrdenProduccion'));

        return $this->render('ordenproducciondetalle/list.html.twig', array(
            'ordenProduccion' => $ordenProduccion,
        ));
    }

    /**
     * Lists all OrdenProduccionDetalle entities.
     *
     * @Route("/", name="orden_produccion_detalle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ordenProduccionDetalles = $em->getRepository('AppBundle:OrdenProduccionDetalle')->findAll();

        return $this->render('ordenproducciondetalle/index.html.twig', array(
            'ordenProduccionDetalles' => $ordenProduccionDetalles,
        ));
    }

    /**
     * Creates a new OrdenProduccionDetalle entity.
     *
     * @Route("/new", name="orden_produccion_detalle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ordenProduccionDetalle = new OrdenProduccionDetalle();
        $form = $this->createForm('AppBundle\Form\OrdenProduccionDetalleType', $ordenProduccionDetalle, array(
            'action' => $this->generateUrl('orden_produccion_detalle_new'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ordenProduccion=$form['ordenProduccion']->getData();
                        
            $pedido=$ordenProduccion->getPedido();
            $pedido->setTotal($pedido->getTotal()+$form['precio']->getData());

            if ($request->files->get('inputFotoObservacion') != null) {
                $file = $request->files->get('inputFotoObservacion');
                $originalName = $file->getClientOriginalName();
                $dir=__DIR__.'/../../../web/img/uploads/observations';
                $extension = $file->guessExtension();
                $file->move($dir,$originalName);

                $ordenProduccionDetalle->setFotoObservacion($originalName);
            }
            
            $em->persist($pedido);
            $em->persist($ordenProduccionDetalle);
            $em->flush();

            return $this->redirectToRoute('orden_produccion_detalle_list', array(
                'idOrdenProduccion' => $ordenProduccionDetalle->getOrdenProduccion()->getId()
                )
            );
        }

        $em = $this->getDoctrine()->getManager();

        $ordenProduccion = $em->getRepository('AppBundle:OrdenProduccion')->find($request->query->get('idOrdenProduccion'));

        return $this->render('ordenproducciondetalle/new.html.twig', array(
            'ordenProduccionDetalle' => $ordenProduccionDetalle,
            'ordenProduccion' => $ordenProduccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrdenProduccionDetalle entity.
     *
     * @Route("/{id}", name="orden_produccion_detalle_show")
     * @Method("GET")
     */
    public function showAction(OrdenProduccionDetalle $ordenProduccionDetalle)
    {

        $pedido=$ordenProduccionDetalle->getOrdenProduccion()->getPedido(); 


        $hora = $ordenProduccionDetalle->getOrdenProduccion()->getHorario()->getInicio();
        $jornada = $ordenProduccionDetalle->getOrdenProduccion()->getHorario()->getJornada();
        $fecha = $ordenProduccionDetalle->getOrdenProduccion()->getFechaEntrega()->format('Y-m-d H:i:s');

        if($jornada == 'PM') {
            $hora = $hora + 12 ;
        }

        $nuevafecha = strtotime ( '+'.$hora.' hour' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j H:i:s' , $nuevafecha );

        $fecha1 = new \DateTime($nuevafecha);



        $deleteForm = $this->createDeleteForm($ordenProduccionDetalle);

         $user = $this->getUser();
         if($user->getRole()=="ROLE_SHIPPING"){

            $repository = $this->getDoctrine()->getRepository('AppBundle:OrdenProduccionDetalle');

            $ordenProduccionDetalleEstados = $repository->findBy(array("ordenProduccionEstado"=>3));

            return $this->render('ordenproducciondetalle/show.shipping.html.twig', array(
            'ordenProduccionDetalleEstados' => $ordenProduccionDetalleEstados,    
            'ordenProduccionDetalle' => $ordenProduccionDetalle,
            'delete_form' => $deleteForm->createView(),
        ));
         }
        return $this->render('ordenproducciondetalle/show.html.twig', array(
            'nuevafecha' => $fecha1,
            'ordenProduccionDetalle' => $ordenProduccionDetalle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrdenProduccionDetalle entity.
     *
     * @Route("/{id}/edit", name="orden_produccion_detalle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OrdenProduccionDetalle $ordenProduccionDetalle)
    {
        $deleteForm = $this->createDeleteForm($ordenProduccionDetalle);
        $editForm = $this->createForm('AppBundle\Form\OrdenProduccionDetalleType', $ordenProduccionDetalle, array(
            'action' => $this->generateUrl('orden_produccion_detalle_edit', array('id' => $ordenProduccionDetalle->getId())),
            'method' => 'POST',
        ));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ordenProduccion=$editForm['ordenProduccion']->getData();
                        
            $pedido=$ordenProduccion->getPedido();
            $pedido->setTotal($pedido->getTotal()+$precio=$editForm['precio']->getData());

            if ($request->files->get('inputFotoObservacion') != null) {
                $file = $request->files->get('inputFotoObservacion');
                $originalName = $file->getClientOriginalName();
                $dir=__DIR__.'/../../../web/img/uploads/observations';
                $extension = $file->guessExtension();
                $file->move($dir,$originalName);

                $ordenProduccionDetalle->setFotoObservacion($originalName);
            }
            
            $em->persist($pedido);
            $em->persist($ordenProduccionDetalle);
            $em->flush();
            return $this->redirectToRoute('orden_produccion_detalle_list', array('idOrdenProduccion' => $ordenProduccionDetalle->getOrdenProduccion()->getId()));
        }

        return $this->render('ordenproducciondetalle/edit.html.twig', array(
            'ordenProduccionDetalle' => $ordenProduccionDetalle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OrdenProduccionDetalle entity.
     *
     * @Route("/delete/{id}", name="orden_produccion_detalle_delete")
     * @Method("GET")
     */
    public function deleteAction(OrdenProduccionDetalle $ordenProduccionDetalle)
    {
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($ordenProduccionDetalle);
        $em->flush();

        return $this->redirectToRoute('orden_produccion_show',array('id' => $ordenProduccionDetalle->getOrdenProduccion()->getId()));
    }

    /**
     * Creates a form to delete a OrdenProduccionDetalle entity.
     *
     * @param OrdenProduccionDetalle $ordenProduccionDetalle The OrdenProduccionDetalle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrdenProduccionDetalle $ordenProduccionDetalle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orden_produccion_detalle_delete', array('id' => $ordenProduccionDetalle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * cambia el estado de pendiente a asignada la orden para q sea visible desde produccion.
     *
     * @Route("/asignar/estado/{id}/{idEstado}", name="orden_produccion_asignar_estado")
     * @Method("GET")
     */

    public function asignarEstadoAction($id, $idEstado){

        $em = $this->getDoctrine()->getManager();
        $ordenProduccionDetalle = $em->getRepository('AppBundle:OrdenProduccionDetalle')->find($id);

        $ordenProduccionEstado = $em->getRepository('AppBundle:OrdenProduccionEstado')->find($idEstado);

        $ordenProduccionDetalle->setOrdenProduccionEstado($ordenProduccionEstado);

        $em->persist($ordenProduccionDetalle);
        $em->flush();

        return $this->redirectToRoute('orden_produccion_detalle_show',array(
                'id' => $ordenProduccionDetalle->getId()
            ));

    }


     /**
     * cambia el orden de despacho
     *
     * @Route("/despacho", name="orden_despacho")
     * @Method("POST")
     */
    public function OrdenDespacho(Request $request){    


        $em = $this->getDoctrine()->getManager();
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        $user = $this->getUser();

        $ordenProduccionDetalleEntregada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleEntregada();

        $ordenProduccionDetalleDespacho = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleDespacho();

        $ordenProduccionDetalleTerminada = $em->getRepository('AppBundle:OrdenProduccionDetalle')->getOrdenProduccionDetalleTerminada();

        if ($request->request->get('destino')) {
            if ($request->getMethod('POST')) 
               {

                    foreach ($request->request->get('destino') as $idOrdenProduccionDetalle) {
                        $despacho = new Despacho();
                        
                        $ordenProduccionDetalle = $em->getRepository('AppBundle:OrdenProduccionDetalle')->find($idOrdenProduccionDetalle);

                        $ordenProduccionEstado = $em->getRepository('AppBundle:OrdenProduccionEstado')->find(4);

                        $ordenProduccionDetalle->setOrdenProduccionEstado($ordenProduccionEstado);
                        $em->persist($ordenProduccionDetalle);
                        $despacho->setUsuario($user);
                        $despacho->setOrdenProduccionDetalle($ordenProduccionDetalle);


                        $em->persist($despacho);

                        $em->flush();
                        
                    }

                        


                        return $this->redirectToRoute('homepage');
               }
        }else{
                        return $this->redirectToRoute('homepage');

           
        }
        
        

    }




    
}
