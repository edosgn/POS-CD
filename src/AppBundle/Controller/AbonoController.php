<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Abono;
use AppBundle\Form\AbonoType;

/**
 * Abono controller.
 *
 * @Route("/abono")
 */
class AbonoController extends Controller
{
    /**
     * Lists all Abono entities.
     *
     * @Route("/", name="abono_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $abonos = $em->getRepository('AppBundle:Abono')->findAll();

        return $this->render('abono/index.html.twig', array(
            'abonos' => $abonos,
        ));
    }

    /**
     * Creates a new Abono entity.
     *
     * @Route("/new", name="abono_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $abono = new Abono();
        $form = $this->createForm('AppBundle\Form\AbonoType', $abono);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($abono);
            $em->flush();

            return $this->redirectToRoute('abono_show', array('id' => $abono->getId()));
        }

        return $this->render('abono/new.html.twig', array(
            'abono' => $abono,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Abono entity.
     *
     * @Route("/{id}", name="abono_show")
     * @Method("GET")
     */
    public function showAction(Abono $abono)
    {
        $deleteForm = $this->createDeleteForm($abono);

        return $this->render('abono/show.html.twig', array(
            'abono' => $abono,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Abono entity.
     *
     * @Route("/{id}/edit", name="abono_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Abono $abono)
    {
        $deleteForm = $this->createDeleteForm($abono);
        $editForm = $this->createForm('AppBundle\Form\AbonoType', $abono);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($abono);
            $em->flush();

            return $this->redirectToRoute('abono_edit', array('id' => $abono->getId()));
        }

        return $this->render('abono/edit.html.twig', array(
            'abono' => $abono,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Abono entity.
     *
     * @Route("/{id}", name="abono_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Abono $abono)
    {
        $form = $this->createDeleteForm($abono);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($abono);
            $em->flush();
        }

        return $this->redirectToRoute('abono_index');
    }

    /**
     * Creates a form to delete a Abono entity.
     *
     * @param Abono $abono The Abono entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Abono $abono)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abono_delete', array('id' => $abono->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
