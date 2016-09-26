<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\UsuarioCategoria;
use AppBundle\Form\UsuarioCategoriaType;

/**
 * UsuarioCategoria controller.
 *
 * @Route("/usuario_categoria")
 */
class UsuarioCategoriaController extends Controller
{
    /**
     * Creates a new UsuarioCategoria entity.
     *
     * @Route("/register", name="usuario_categoria_register")
     * @Method("POST")
     */
    public function registerAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            $usuario = $em->getRepository('AppBundle:Usuario')->find($request->request->get('idUsuario'));

            $query = $em->createQuery('DELETE AppBundle:UsuarioCategoria uc WHERE uc.responsable = '.$usuario->getId());
            $query->execute();

            if ($request->request->get('select') != null) {
                foreach($request->request->get('select') as $categoria){
                    $usuarioCategoria = new UsuarioCategoria();

                    $categoria = $em->getRepository('AppBundle:DetalleCategoria')->find($categoria);

                    $usuarioCategoria->setDetalleCategoria($categoria);
                    $usuarioCategoria->setResponsable($usuario);

                    $em->persist($usuarioCategoria);
                    $em->flush();
                }
            }
            return $this->redirectToRoute('usuario_show', array('id' => $usuario->getId()));
        }
    }

    /**
     * Lists all UsuarioCategoria entities.
     *
     * @Route("/", name="usuario_categoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarioCategorias = $em->getRepository('AppBundle:UsuarioCategoria')->findAll();

        return $this->render('usuario_categoria/index.html.twig', array(
            'usuarioCategorias' => $usuarioCategorias,
        ));
    }

    /**
     * Creates a new UsuarioCategoria entity.
     *
     * @Route("/new", name="usuario_categoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuarioCategorium = new UsuarioCategoria();
        $form = $this->createForm('AppBundle\Form\UsuarioCategoriaType', $usuarioCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuarioCategorium);
            $em->flush();

            return $this->redirectToRoute('usuario_categoria_show', array('id' => $usuarioCategorium->getId()));
        }

        return $this->render('usuario_categoria/new.html.twig', array(
            'usuarioCategorium' => $usuarioCategorium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UsuarioCategoria entity.
     *
     * @Route("/{id}", name="usuario_categoria_show")
     * @Method("GET")
     */
    public function showAction(UsuarioCategoria $usuarioCategorium)
    {
        $deleteForm = $this->createDeleteForm($usuarioCategorium);

        return $this->render('usuario_categoria/show.html.twig', array(
            'usuarioCategorium' => $usuarioCategorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UsuarioCategoria entity.
     *
     * @Route("/{id}/edit", name="usuario_categoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UsuarioCategoria $usuarioCategorium)
    {
        $deleteForm = $this->createDeleteForm($usuarioCategorium);
        $editForm = $this->createForm('AppBundle\Form\UsuarioCategoriaType', $usuarioCategorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuarioCategorium);
            $em->flush();

            return $this->redirectToRoute('usuario_categoria_edit', array('id' => $usuarioCategorium->getId()));
        }

        return $this->render('usuario_categoria/edit.html.twig', array(
            'usuarioCategorium' => $usuarioCategorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UsuarioCategoria entity.
     *
     * @Route("/{id}", name="usuario_categoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UsuarioCategoria $usuarioCategorium)
    {
        $form = $this->createDeleteForm($usuarioCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuarioCategorium);
            $em->flush();
        }

        return $this->redirectToRoute('usuario_categoria_index');
    }

    /**
     * Creates a form to delete a UsuarioCategoria entity.
     *
     * @param UsuarioCategoria $usuarioCategorium The UsuarioCategoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UsuarioCategoria $usuarioCategorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_categoria_delete', array('id' => $usuarioCategorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
