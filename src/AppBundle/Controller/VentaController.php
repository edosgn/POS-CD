<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Venta;
use AppBundle\Form\VentaType;

/**
 * Venta controller.
 *
 * @Route("/venta")
 */
class VentaController extends Controller
{
    /**
     * Lists all Venta entities.
     *
     * @Route("/", name="venta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ventas = $em->getRepository('AppBundle:Venta')->findAll();

        return $this->render('venta/index.html.twig', array(
            'ventas' => $ventas,
        ));
    }

    /**
     * Creates a new Venta entity.
     *
     * @Route("/new", name="venta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $venta = new Venta();
        $form = $this->createForm('AppBundle\Form\VentaType', $venta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pedido=$form['pedido']->getData();

            $pedido->setTotal($pedido->getTotal()+$form['valor']->getData());            

            $venta->setCreatedAt(new \DateTime('now'));
            $em->persist($venta);
            $em->persist($pedido);
            $em->flush();

            return $this->redirectToRoute('venta_show', array('id' => $venta->getId()));
        }

        $em = $this->getDoctrine()->getManager();
        $idPedido=$request->query->get('idPedido');
        $pedido= $em->getRepository('AppBundle:Pedido')->find($idPedido);

        return $this->render('venta/new.html.twig', array(
            'venta' => $venta,
            'pedido' => $pedido,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Venta entity.
     *
     * @Route("/{id}", name="venta_show")
     * @Method("GET")
     */
    public function showAction(Venta $ventum)
    {
        $deleteForm = $this->createDeleteForm($ventum);

        return $this->render('venta/show.html.twig', array(
            'venta' => $ventum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Venta entity.
     *
     * @Route("/{id}/edit", name="venta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Venta $ventum)
    {
        $deleteForm = $this->createDeleteForm($ventum);
        $editForm = $this->createForm('AppBundle\Form\VentaType', $ventum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ventum->setUpdateAt(new \DateTime('now'));
            $em->persist($ventum);
            $em->flush();

            return $this->redirectToRoute('venta_show', array('id' => $ventum->getId()));
        }

        return $this->render('venta/edit.html.twig', array(
            'ventum' => $ventum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Venta entity.
     *
     * @Route("/{id}", name="venta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Venta $ventum)
    {
        $form = $this->createDeleteForm($ventum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ventum);
            $em->flush();
        }

        return $this->redirectToRoute('venta_index');
    }

    /**
     * Creates a form to delete a Venta entity.
     *
     * @param Venta $ventum The Venta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Venta $ventum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('venta_delete', array('id' => $ventum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
