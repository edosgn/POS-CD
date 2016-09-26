<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OrdenProduccionEstado;
use AppBundle\Form\OrdenProduccionEstadoType;

/**
 * OrdenProduccionEstado controller.
 *
 * @Route("/orden_produccion_estado")
 */
class OrdenProduccionEstadoController extends Controller
{
    /**
     * Lists all OrdenProduccionEstado entities.
     *
     * @Route("/", name="orden_produccion_estado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ordenProduccionEstados = $em->getRepository('AppBundle:OrdenProduccionEstado')->findAll();

        return $this->render('ordenproduccionestado/index.html.twig', array(
            'ordenProduccionEstados' => $ordenProduccionEstados,
        ));
    }

    /**
     * Creates a new OrdenProduccionEstado entity.
     *
     * @Route("/new", name="orden_produccion_estado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ordenProduccionEstado = new OrdenProduccionEstado();
        $form = $this->createForm('AppBundle\Form\OrdenProduccionEstadoType', $ordenProduccionEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ordenProduccionEstado);
            $em->flush();

            return $this->redirectToRoute('orden_produccion_estado_show', array('id' => $ordenProduccionEstado->getId()));
        }

        return $this->render('ordenproduccionestado/new.html.twig', array(
            'ordenProduccionEstado' => $ordenProduccionEstado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrdenProduccionEstado entity.
     *
     * @Route("/{id}", name="orden_produccion_estado_show")
     * @Method("GET")
     */
    public function showAction(OrdenProduccionEstado $ordenProduccionEstado)
    {
        $deleteForm = $this->createDeleteForm($ordenProduccionEstado);

        return $this->render('ordenproduccionestado/show.html.twig', array(
            'ordenProduccionEstado' => $ordenProduccionEstado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrdenProduccionEstado entity.
     *
     * @Route("/{id}/edit", name="orden_produccion_estado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OrdenProduccionEstado $ordenProduccionEstado)
    {
        $deleteForm = $this->createDeleteForm($ordenProduccionEstado);
        $editForm = $this->createForm('AppBundle\Form\OrdenProduccionEstadoType', $ordenProduccionEstado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ordenProduccionEstado);
            $em->flush();

            return $this->redirectToRoute('orden_produccion_estado_show', array('id' => $ordenProduccionEstado->getId()));
        }

        return $this->render('ordenproduccionestado/edit.html.twig', array(
            'ordenProduccionEstado' => $ordenProduccionEstado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OrdenProduccionEstado entity.
     *
     * @Route("/{id}", name="orden_produccion_estado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OrdenProduccionEstado $ordenProduccionEstado)
    {
        $form = $this->createDeleteForm($ordenProduccionEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ordenProduccionEstado);
            $em->flush();
        }

        return $this->redirectToRoute('orden_produccion_estado_index');
    }

    /**
     * Creates a form to delete a OrdenProduccionEstado entity.
     *
     * @param OrdenProduccionEstado $ordenProduccionEstado The OrdenProduccionEstado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrdenProduccionEstado $ordenProduccionEstado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orden_produccion_estado_delete', array('id' => $ordenProduccionEstado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
