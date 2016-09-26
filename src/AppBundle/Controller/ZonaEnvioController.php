<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ZonaEnvio;
use AppBundle\Form\ZonaEnvioType;

/**
 * ZonaEnvio controller.
 *
 * @Route("/zona_envio")
 */
class ZonaEnvioController extends Controller
{
    /**
     * Lists all ZonaEnvio entities.
     *
     * @Route("/", name="zona_envio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $zonaEnvios = $em->getRepository('AppBundle:ZonaEnvio')->findAll();

        return $this->render('zonaenvio/index.html.twig', array(
            'zonaEnvios' => $zonaEnvios,
        ));
    }

    /**
     * Creates a new ZonaEnvio entity.
     *
     * @Route("/new", name="zona_envio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $zonaEnvio = new ZonaEnvio();
        $form = $this->createForm('AppBundle\Form\ZonaEnvioType', $zonaEnvio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zonaEnvio);
            $em->flush();

            return $this->redirectToRoute('zona_envio_show', array('id' => $zonaEnvio->getId()));
        }

        return $this->render('zonaenvio/new.html.twig', array(
            'zonaEnvio' => $zonaEnvio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ZonaEnvio entity.
     *
     * @Route("/{id}", name="zona_envio_show")
     * @Method("GET")
     */
    public function showAction(ZonaEnvio $zonaEnvio)
    {
        $deleteForm = $this->createDeleteForm($zonaEnvio);

        return $this->render('zonaenvio/show.html.twig', array(
            'zonaEnvio' => $zonaEnvio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ZonaEnvio entity.
     *
     * @Route("/{id}/edit", name="zona_envio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ZonaEnvio $zonaEnvio)
    {
        $deleteForm = $this->createDeleteForm($zonaEnvio);
        $editForm = $this->createForm('AppBundle\Form\ZonaEnvioType', $zonaEnvio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zonaEnvio);
            $em->flush();

            return $this->redirectToRoute('zona_envio_show', array('id' => $zonaEnvio->getId()));
        }

        return $this->render('zonaenvio/edit.html.twig', array(
            'zonaEnvio' => $zonaEnvio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ZonaEnvio entity.
     *
     * @Route("/{id}", name="zona_envio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ZonaEnvio $zonaEnvio)
    {
        $form = $this->createDeleteForm($zonaEnvio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zonaEnvio);
            $em->flush();
        }

        return $this->redirectToRoute('zona_envio_index');
    }

    /**
     * Creates a form to delete a ZonaEnvio entity.
     *
     * @param ZonaEnvio $zonaEnvio The ZonaEnvio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ZonaEnvio $zonaEnvio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zona_envio_delete', array('id' => $zonaEnvio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
