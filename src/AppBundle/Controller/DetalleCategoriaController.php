<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\DetalleCategoria;
use AppBundle\Form\DetalleCategoriaType;

/**
 * DetalleCategoria controller.
 *
 * @Route("/detalle_categoria")
 */
class DetalleCategoriaController extends Controller
{
    /**
     * Lists all DetalleCategoria entities.
     *
     * @Route("/list", name="detalle_categoria_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $detalleCategorias = $em->getRepository('AppBundle:DetalleCategoria')->findAll();

        return $this->render('detallecategoria/list.html.twig', array(
            'detalleCategorias' => $detalleCategorias,
        ));
    }

    /**
     * Lists all DetalleCategoria entities.
     *
     * @Route("/", name="detalle_categoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $detalleCategorias = $em->getRepository('AppBundle:DetalleCategoria')->findAll();

        return $this->render('detallecategoria/index.html.twig', array(
            'detalleCategorias' => $detalleCategorias,
        ));
    }

    /**
     * Creates a new DetalleCategoria entity.
     *
     * @Route("/new", name="detalle_categoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $detalleCategoria = new DetalleCategoria();
        $form = $this->createForm('AppBundle\Form\DetalleCategoriaType', $detalleCategoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleCategoria);
            $em->flush();

            return $this->redirectToRoute('detalle_categoria_show', array('id' => $detalleCategoria->getId()));
        }

        return $this->render('detallecategoria/new.html.twig', array(
            'detalleCategoria' => $detalleCategoria,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DetalleCategoria entity.
     *
     * @Route("/{id}", name="detalle_categoria_show")
     * @Method("GET")
     */
    public function showAction(DetalleCategoria $detalleCategoria)
    {
        $deleteForm = $this->createDeleteForm($detalleCategoria);

        return $this->render('detallecategoria/show.html.twig', array(
            'detalleCategoria' => $detalleCategoria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DetalleCategoria entity.
     *
     * @Route("/{id}/edit", name="detalle_categoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DetalleCategoria $detalleCategoria)
    {
        $deleteForm = $this->createDeleteForm($detalleCategoria);
        $editForm = $this->createForm('AppBundle\Form\DetalleCategoriaType', $detalleCategoria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleCategoria);
            $em->flush();

            return $this->redirectToRoute('detalle_categoria_show', array('id' => $detalleCategoria->getId()));
        }

        return $this->render('detallecategoria/edit.html.twig', array(
            'detalleCategoria' => $detalleCategoria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DetalleCategoria entity.
     *
     * @Route("/{id}", name="detalle_categoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DetalleCategoria $detalleCategoria)
    {
        $form = $this->createDeleteForm($detalleCategoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($detalleCategoria);
            $em->flush();
        }

        return $this->redirectToRoute('detalle_categoria_index');
    }

    /**
     * Creates a form to delete a DetalleCategoria entity.
     *
     * @param DetalleCategoria $detalleCategoria The DetalleCategoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DetalleCategoria $detalleCategoria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('detalle_categoria_delete', array('id' => $detalleCategoria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
