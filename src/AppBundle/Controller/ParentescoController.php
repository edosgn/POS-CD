<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Parentesco;
use AppBundle\Form\ParentescoType;

/**
 * Parentesco controller.
 *
 * @Route("/parentesco")
 */
class ParentescoController extends Controller
{
    /**
     * Lists all Parentesco entities.
     *
     * @Route("/", name="parentesco_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $parentescos = $em->getRepository('AppBundle:Parentesco')->findAll();

        return $this->render('parentesco/index.html.twig', array(
            'parentescos' => $parentescos,
        ));
    }

    /**
     * Creates a new Parentesco entity.
     *
     * @Route("/new", name="parentesco_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $parentesco = new Parentesco();
        $form = $this->createForm('AppBundle\Form\ParentescoType', $parentesco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parentesco);
            $em->flush();

            return $this->redirectToRoute('parentesco_show', array('id' => $parentesco->getId()));
        }

        return $this->render('parentesco/new.html.twig', array(
            'parentesco' => $parentesco,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Parentesco entity.
     *
     * @Route("/{id}", name="parentesco_show")
     * @Method("GET")
     */
    public function showAction(Parentesco $parentesco)
    {
        $deleteForm = $this->createDeleteForm($parentesco);

        return $this->render('parentesco/show.html.twig', array(
            'parentesco' => $parentesco,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Parentesco entity.
     *
     * @Route("/{id}/edit", name="parentesco_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Parentesco $parentesco)
    {
        $deleteForm = $this->createDeleteForm($parentesco);
        $editForm = $this->createForm('AppBundle\Form\ParentescoType', $parentesco);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parentesco);
            $em->flush();

            return $this->redirectToRoute('parentesco_show', array('id' => $parentesco->getId()));
        }

        return $this->render('parentesco/edit.html.twig', array(
            'parentesco' => $parentesco,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Parentesco entity.
     *
     * @Route("/{id}", name="parentesco_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Parentesco $parentesco)
    {
        $form = $this->createDeleteForm($parentesco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parentesco);
            $em->flush();
        }

        return $this->redirectToRoute('parentesco_index');
    }

    /**
     * Creates a form to delete a Parentesco entity.
     *
     * @param Parentesco $parentesco The Parentesco entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Parentesco $parentesco)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parentesco_delete', array('id' => $parentesco->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
