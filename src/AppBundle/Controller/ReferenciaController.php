<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Referencia;
use AppBundle\Form\ReferenciaType;

/**
 * Referencia controller.
 *
 * @Route("/referencia")
 */
class ReferenciaController extends Controller
{

    /** 
    * Estructura respuesta de arreglo json datos de preferido
    * @Route("/find/preferido", name="referencia_preferido_json")
    * @Method("GET")
    */
    public function preferidoJsonAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();

       $id= $request->query->get('id');
       $referencia = $em->getRepository('AppBundle:Referencia')->find($id);

       $response = new JsonResponse();

       $entidades = array();
       $entidades[] = array(
           'nombres'=>$referencia->getNombres(),
           'apellidos'=>$referencia->getApellidos(),
           'telefono'=>$referencia->getTelefono(),
           'direccion'=>$referencia->getDireccion()
       );


       $response->setData($entidades);

       return $response;
    }

     /**
     * Lists all Referencia entities for Cliente.
     *
     * @Route("/list", name="referencia_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $idCliente=$request->query->get('idCliente');
        $cliente= $em->getRepository('AppBundle:Cliente')->find($idCliente);

        $referencias = $cliente->getReferencias();

        return $this->render('referencia/list.html.twig', array(
            'referencias' => $referencias,
        ));
    }

    /**
     * Lists all Referencia entities.
     *
     * @Route("/", name="referencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $referencias = $em->getRepository('AppBundle:Referencia')->findAll();

        return $this->render('referencia/index.html.twig', array(
            'referencias' => $referencias,
        ));
    }

    /**
     * Creates a new Referencia entity.
     *
     * @Route("/add", name="referencia_add")
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $referencia = new Referencia();
        $form = $this->createForm('AppBundle\Form\ReferenciaType', $referencia, array(
            'action' => $this->generateUrl('referencia_add'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            $referencia->setFechaEspecial(new \DateTime($request->request->get('fechaEspecial')));

            $referencia->setCliente($form['cliente']->getData());
            $referencia->setParentesco($form['parentesco']->getData());


            $em->persist($referencia);
            $em->flush();

            return $this->redirectToRoute('referencia_list', array('idCliente' => $referencia->getCliente()->getId()));
        }

        $em = $this->getDoctrine()->getManager();
        $idCliente=$request->query->get('idCliente');
        $cliente= $em->getRepository('AppBundle:Cliente')->find($idCliente);

        $parentescos= $em->getRepository('AppBundle:Parentesco')->findAll();

        return $this->render('referencia/add.html.twig', array(
            'referencia' => $referencia,
            'cliente' => $cliente,
            'parentescos' => $parentescos,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Referencia entity.
     *
     * @Route("/new", name="referencia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $referencia = new Referencia();
        $form = $this->createForm('AppBundle\Form\ReferenciaType', $referencia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $referencia->setFechaEspecial(new \DateTime($request->request->get('fechaEspecial')));

            $dominio=($request->request->get('dominioCorreo'));
            $correo=$form['correo']->getData();
            $referencia->setCorreo($correo.$dominio);

            $em->persist($referencia);
            $em->flush();

            return $this->redirectToRoute('cliente_show', array('id' => $referencia->getCliente()->getId()));
        }

        $em = $this->getDoctrine()->getManager();
        $idCliente=$request->query->get('idCliente');
        $cliente= $em->getRepository('AppBundle:Cliente')->find($idCliente);
        $nombre=$request->query->get('nombre');
        $tel=$request->query->get('telefono');

        return $this->render('referencia/new.html.twig', array(
            'referencia' => $referencia,
            'cliente' => $cliente,
            'nombre' => $nombre,
            'telefono' => $tel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Referencia entity.
     *
     * @Route("/{id}", name="referencia_show")
     * @Method("GET")
     */
    public function showAction(Referencia $referencia)
    {
        $deleteForm = $this->createDeleteForm($referencia);

        return $this->render('referencia/show.html.twig', array(
            'referencia' => $referencia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Referencia entity.
     *
     * @Route("/{id}/edit", name="referencia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Referencia $referencia)
    {
        $deleteForm = $this->createDeleteForm($referencia);
        $editForm = $this->createForm('AppBundle\Form\ReferenciaType', $referencia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $referencia->setFechaEspecial(new \DateTime($request->request->get('fechaEspecial')));

            $dominio=($request->request->get('dominioCorreo'));
            $nombre=$editForm['correo']->getData();
            $referencia->setCorreo($nombre.$dominio);
            
            $em->persist($referencia);
            $em->flush();

            return $this->redirectToRoute('referencia_show', array('id' => $referencia->getId()));
        }

        return $this->render('referencia/edit.html.twig', array(
            'referencia' => $referencia,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Referencia entity.
     *
     * @Route("/{id}", name="referencia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Referencia $referencia)
    {
        $form = $this->createDeleteForm($referencia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($referencia);
            $em->flush();
        }

        return $this->redirectToRoute('referencia_index');
    }

     /**
     * Creates a form to delete a Referencia entity.
     *
     * @param Referencia $referencia The Referencia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Referencia $referencia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('referencia_delete', array('id' => $referencia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
