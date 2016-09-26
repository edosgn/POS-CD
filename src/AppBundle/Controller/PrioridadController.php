<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Prioridad;
use AppBundle\Form\PrioridadType;

/**
 * Prioridad controller.
 *
 * @Route("/prioridad")
 */
class PrioridadController extends Controller
{
    /**
     * Lists all Prioridad entities.
     *
     * @Route("/", name="prioridad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prioridads = $em->getRepository('AppBundle:Prioridad')->findAll();

        return $this->render('prioridad/index.html.twig', array(
            'prioridads' => $prioridads,
        ));
    }

    /**
     * Creates a new Prioridad entity.
     *
     * @Route("/new", name="prioridad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $prioridad = new Prioridad();
        $form = $this->createForm('AppBundle\Form\PrioridadType', $prioridad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prioridad);
            $em->flush();

            return $this->redirectToRoute('prioridad_show', array('id' => $prioridad->getId()));
        }

        return $this->render('prioridad/new.html.twig', array(
            'prioridad' => $prioridad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Prioridad entity.
     *
     * @Route("/{id}", name="prioridad_show")
     * @Method("GET")
     */
    public function showAction(Prioridad $prioridad)
    {
        $deleteForm = $this->createDeleteForm($prioridad);

        return $this->render('prioridad/show.html.twig', array(
            'prioridad' => $prioridad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Prioridad entity.
     *
     * @Route("/{id}/edit", name="prioridad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Prioridad $prioridad)
    {
        $deleteForm = $this->createDeleteForm($prioridad);
        $editForm = $this->createForm('AppBundle\Form\PrioridadType', $prioridad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prioridad);
            $em->flush();

            return $this->redirectToRoute('prioridad_show', array('id' => $prioridad->getId()));
        }

        return $this->render('prioridad/edit.html.twig', array(
            'prioridad' => $prioridad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Prioridad entity.
     *
     * @Route("/{id}", name="prioridad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Prioridad $prioridad)
    {
        $form = $this->createDeleteForm($prioridad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prioridad);
            $em->flush();
        }

        return $this->redirectToRoute('prioridad_index');
    }

    /**
     * Creates a form to delete a Prioridad entity.
     *
     * @param Prioridad $prioridad The Prioridad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Prioridad $prioridad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prioridad_delete', array('id' => $prioridad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
