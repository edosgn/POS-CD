<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OrdenProduccion;
use AppBundle\Entity\Pedido;
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

        return $this->render('ordenproduccion/show.html.twig', array(
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

        return $this->render('ordenproduccion/edit.html.twig', array(
            'ordenProduccion' => $ordenProduccion,
            'step' => $request->query->get('idStep'),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OrdenProduccion entity.
     *
     * @Route("/{id}", name="orden_produccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OrdenProduccion $ordenProduccion)
    {
        $form = $this->createDeleteForm($ordenProduccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ordenProduccion);
            $em->flush();
        }

        return $this->redirectToRoute('orden_produccion_index');
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
    
}
