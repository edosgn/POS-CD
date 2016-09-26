<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\MensajeCategoria;
use AppBundle\Form\MensajeCategoriaType;

/**
 * MensajeCategoria controller.
 *
 * @Route("/mensaje_categoria")
 */
class MensajeCategoriaController extends Controller
{
    /**
     * Lists all MensajeCategoria entities.
     *
     * @Route("/list", name="mensaje_categoria_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mensajeCategorias = $em->getRepository('AppBundle:MensajeCategoria')->findAll();

        return $this->render('mensajecategoria/list.html.twig', array(
            'mensajeCategorias' => $mensajeCategorias,
        ));
    }

    /**
     * Lists all MensajeCategoria entities.
     *
     * @Route("/", name="mensaje_categoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mensajeCategorias = $em->getRepository('AppBundle:MensajeCategoria')->findAll();

        return $this->render('mensajecategoria/index.html.twig', array(
            'mensajeCategorias' => $mensajeCategorias,
        ));
    }

    /**
     * Creates a new MensajeCategoria entity.
     *
     * @Route("/new", name="mensaje_categoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mensajeCategoria = new MensajeCategoria();
        $form = $this->createForm('AppBundle\Form\MensajeCategoriaType', $mensajeCategoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mensajeCategoria);
            $em->flush();

            return $this->redirectToRoute('mensaje_categoria_show', array('id' => $mensajeCategoria->getId()));
        }

        return $this->render('mensajecategoria/new.html.twig', array(
            'mensajeCategoria' => $mensajeCategoria,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MensajeCategoria entity.
     *
     * @Route("/{id}", name="mensaje_categoria_show")
     * @Method("GET")
     */
    public function showAction(MensajeCategoria $mensajeCategoria)
    {
        $deleteForm = $this->createDeleteForm($mensajeCategoria);

        return $this->render('mensajecategoria/show.html.twig', array(
            'mensajeCategoria' => $mensajeCategoria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MensajeCategoria entity.
     *
     * @Route("/{id}/edit", name="mensaje_categoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MensajeCategoria $mensajeCategoria)
    {
        $deleteForm = $this->createDeleteForm($mensajeCategoria);
        $editForm = $this->createForm('AppBundle\Form\MensajeCategoriaType', $mensajeCategoria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mensajeCategoria);
            $em->flush();

            return $this->redirectToRoute('mensaje_categoria_show', array('id' => $mensajeCategoria->getId()));
        }

        return $this->render('mensajecategoria/edit.html.twig', array(
            'mensajeCategoria' => $mensajeCategoria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MensajeCategoria entity.
     *
     * @Route("/{id}", name="mensaje_categoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MensajeCategoria $mensajeCategoria)
    {
        $form = $this->createDeleteForm($mensajeCategoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mensajeCategoria);
            $em->flush();
        }

        return $this->redirectToRoute('mensaje_categoria_index');
    }

    /**
     * Creates a form to delete a MensajeCategoria entity.
     *
     * @param MensajeCategoria $mensajeCategoria The MensajeCategoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MensajeCategoria $mensajeCategoria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mensaje_categoria_delete', array('id' => $mensajeCategoria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
