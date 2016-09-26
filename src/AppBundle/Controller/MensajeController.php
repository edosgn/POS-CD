<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Mensaje;
use AppBundle\Form\MensajeType;

/**
 * Mensaje controller.
 *
 * @Route("/mensaje")
 */
class MensajeController extends Controller
{
    /** 
    * Estructura respuesta de arreglo json datos de mensaje
    * @Route("/find/mensaje", name="mensaje_json")
    * @Method("GET")
    */
    public function mensajeJsonAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();

       $id= $request->query->get('id');
       $mensaje = $em->getRepository('AppBundle:Mensaje')->find($id);

       $response = new JsonResponse();

       $entidades = array();
       $entidades[] = array(
           'nombre'=>$mensaje->getDescripcion(), 
           'idMensaje'=>$mensaje->getId()
       );

       $response->setData($entidades);

       return $response;
    }

    /**
     * Lists all Mensaje entities.
     *
     * @Route("/list", name="mensaje_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $mensajes = $em->getRepository('AppBundle:Mensaje')->findBy(
            array(
                'mensajeCategoria' => $request->query->get('idMensajeCategoria')
            )
        );

        $mensajeCategoria = $em->getRepository('AppBundle:mensajeCategoria')->find($request->query->get('idMensajeCategoria'));

        return $this->render('mensaje/list.html.twig', array(
            'mensajes' => $mensajes,
            'mensajeCategoria' => $mensajeCategoria,
        ));
    }

    /**
     * Lists all Mensaje entities.
     *
     * @Route("/", name="mensaje_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mensajes = $em->getRepository('AppBundle:Mensaje')->findAll();

        return $this->render('mensaje/index.html.twig', array(
            'mensajes' => $mensajes,
        ));
    }

    /**
     * Creates a new Mensaje entity.
     *
     * @Route("/new", name="mensaje_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mensaje = new Mensaje();
        $form = $this->createForm('AppBundle\Form\MensajeType', $mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mensaje);
            $em->flush();

            return $this->redirectToRoute('mensaje_show', array('id' => $mensaje->getId()));
        }

        return $this->render('mensaje/new.html.twig', array(
            'mensaje' => $mensaje,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Mensaje entity.
     *
     * @Route("/{id}", name="mensaje_show")
     * @Method("GET")
     */
    public function showAction(Mensaje $mensaje)
    {
        $deleteForm = $this->createDeleteForm($mensaje);

        return $this->render('mensaje/show.html.twig', array(
            'mensaje' => $mensaje,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Mensaje entity.
     *
     * @Route("/{id}/edit", name="mensaje_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mensaje $mensaje)
    {
        $deleteForm = $this->createDeleteForm($mensaje);
        $editForm = $this->createForm('AppBundle\Form\MensajeType', $mensaje);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mensaje);
            $em->flush();

            return $this->redirectToRoute('mensaje_show', array('id' => $mensaje->getId()));
        }

        return $this->render('mensaje/edit.html.twig', array(
            'mensaje' => $mensaje,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Mensaje entity.
     *
     * @Route("/{id}", name="mensaje_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mensaje $mensaje)
    {
        $form = $this->createDeleteForm($mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mensaje);
            $em->flush();
        }

        return $this->redirectToRoute('mensaje_index');
    }

    /**
     * Creates a form to delete a Mensaje entity.
     *
     * @param Mensaje $mensaje The Mensaje entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mensaje $mensaje)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mensaje_delete', array('id' => $mensaje->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
