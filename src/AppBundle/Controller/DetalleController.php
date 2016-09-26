<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Detalle;
use AppBundle\Form\DetalleType;

/**
 * Detalle controller.
 *
 * @Route("/detalle")
 */
class DetalleController extends Controller
{
    /** 
    * Estructura respuesta de arreglo json datos de detalle
    * @Route("/find/detalle", name="detalle_json")
    * @Method("GET")
    */
    public function detalleJsonAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();

       $id= $request->query->get('id');
       $detalle = $em->getRepository('AppBundle:Detalle')->find($id);

       $response = new JsonResponse();

       $entidades = array();
       $entidades[] = array(
           'nombre'=>$detalle->getNombre(), 
           'precioBase'=>$detalle->getPrecioBase(),
           'idDetalle'=>$detalle->getId()
       );


       $response->setData($entidades);

       return $response;
    }

    /**
     * Lists all Referencia entities.
     *
     * @Route("/list", name="detalle_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $detalles= $em->getRepository('AppBundle:Detalle')->findBy(
            array(
                'detalleCategoria' => $request->query->get('idDetalleCategoria')
            )
        );

        return $this->render('detalle/list.html.twig', array(
            'detalles' => $detalles,
        ));
    }

    /**
     * Lists all Detalle entities.
     *
     * @Route("/", name="detalle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $detalles = $em->getRepository('AppBundle:Detalle')->findAll();

        return $this->render('detalle/index.html.twig', array(
            'detalles' => $detalles,
        ));
    }

    /**
     * Creates a new Detalle entity.
     *
     * @Route("/new", name="detalle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $detalle = new Detalle();
        $form = $this->createForm('AppBundle\Form\DetalleType', $detalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalle);
            $em->flush();

            return $this->redirectToRoute('detalle_show', array('id' => $detalle->getId()));
        }

        return $this->render('detalle/new.html.twig', array(
            'detalle' => $detalle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Detalle entity.
     *
     * @Route("/{id}", name="detalle_show")
     * @Method("GET")
     */
    public function showAction(Detalle $detalle)
    {
        $deleteForm = $this->createDeleteForm($detalle);

        return $this->render('detalle/show.html.twig', array(
            'detalle' => $detalle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Detalle entity.
     *
     * @Route("/{id}/edit", name="detalle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Detalle $detalle)
    {
        $deleteForm = $this->createDeleteForm($detalle);
        $editForm = $this->createForm('AppBundle\Form\DetalleType', $detalle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalle);
            $em->flush();

            return $this->redirectToRoute('detalle_show', array('id' => $detalle->getId()));
        }

        return $this->render('detalle/edit.html.twig', array(
            'detalle' => $detalle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Detalle entity.
     *
     * @Route("/{id}", name="detalle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Detalle $detalle)
    {
        $form = $this->createDeleteForm($detalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($detalle);
            $em->flush();
        }

        return $this->redirectToRoute('detalle_index');
    }

    /**
     * Creates a form to delete a Detalle entity.
     *
     * @param Detalle $detalle The Detalle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Detalle $detalle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('detalle_delete', array('id' => $detalle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
