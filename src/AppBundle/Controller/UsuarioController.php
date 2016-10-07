<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /** 
    * Estructura respuesta de arreglo json datos de responsable
    * @Route("/find/responsable", name="usuario_responsable_json")
    * @Method("GET")
    */
    public function responsableJsonAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();

       $usuario = $em->getRepository('AppBundle:Usuario')->find($request->query->get('id'));

       $response = new JsonResponse();

       $entidades = array();
       $entidades[] = array(
           'id'=>$usuario->getId()
       );


       $response->setData($entidades);

       return $response;
    }

    /**
     * Formulario para recuperar contraseña
     *
     * @Route("/password/recovery", name="usuario_password_recovery")
     * @Method({"GET", "POST"})
     */
    public function passRecoveryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if($request->getMethod() == 'POST') {
            $correo = $request->request->get('txtCorreo');

            $usuario = $em->getRepository('AppBundle:Usuario')->findOneByCorreo($correo);

            if (!$usuario) {
                $this->get('session')->getFlashBag()->set('error', "Error el correo digitado no existe.");
                return $this->redirect($this->generateUrl('usuario_login'));
            }

            /* === Asigna valores a contraseña y salt === */
            $salt = (base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
            $claveAleatoria = $this->container->get('app.twig_extension')->randomString();
            $password = $encoder->encodePassword($claveAleatoria, $salt);

            $usuario->setPassword($password);
            $usuario->setSalt($salt); 

            $em->flush();

            //E-Mail parameters
            /*$subject = "Recuperar Constraseña";
            $to = $usuario->getCorreo();
            $data = array('entity'=>$usuario,'password'=>$claveAleatoria);
            $plantilla = 'Default/emailRecovery.html.twig';
            //Envio de E-Mail
            if($this->get('app.myMailer')->sendEmail($subject,$to,$data,$plantilla) == true){
                $this->get('session')->getFlashBag()->set('info', "Contraseña de acceso enviada a su correo!");
            }else{
                $this->get('session')->getFlashBag()->set('error', "No se pudo enviar correo confirmando contraseña!");
            } */
           
            return $this->redirect($this->generateUrl('usuario_login'));
        }

        return $this->render('usuario/recovery.html.twig');
    }

    /**
     * Formulario para cambiar contraseña
     *
     * @Route("/password/validate", name="usuario_password_validate")
     * @Method("POST")
     */
    public function passValidateAction($passwordCurrent, $usuario)
    {
        /* === Asigna valores a contraseña y salt === */
        $salt = (base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
        $passwordCurrentEncoded = $encoder->encodePassword($passwordCurrent, $salt);

        $response = false;

        if ($passwordCurrentEncoded == $usuario->getPassword()) {
            $response = true;
        }

        return $response;
    }

    /**
     * Creates a new Usuario Foto.
     *
     * @Route("/foto", name="usuario_foto")
     * @Method("POST")
     */
    public function fotoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $idUsuario = $request->request->get('idUsuario');
        $usuario = $em->getRepository('AppBundle:Usuario')->find($idUsuario);

        if (!$usuario) {
            throw $this->createNotFoundException('Unable to find Usuario usuario.');
        }

        $file = $request->files->get('inputFoto');
        $extension = $file->guessExtension();
        $filename = $usuario->getIdentificacion().".".$extension;
        $dir=__DIR__.'/../../../web/images/profiles';

        $file->move($dir,$filename);

        $usuario->setFoto($filename);
        $em->flush();

        return $this->redirect($this->generateUrl('usuario_show', array('id' => $idUsuario)));
    }

    /**
     * Realiza la verificación y renderiza el formulario de login.
     */
    public function loginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
            );

        return $this->render('usuario/login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error
            ));
    }

    /**
     * Lists all Usuario entities ROLE PRODUCTION.
     *
     * @Route("/production/list", name="usuario_production_list")
     * @Method("GET")
     */
    public function productionListAction()
    {
        $em = $this->getDoctrine()->getManager();


        $usuarios = $em->getRepository('AppBundle:Usuario')->findBy(
            array(
                'role' => 'ROLE_PRODUCTION',
                'estado' => 1
            )
        );

        return $this->render('usuario/list.production.html.twig', array(
            'usuarios' => $usuarios,
        ));
    }

    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuariosAdmin = $em->getRepository('AppBundle:Usuario')->findByRole(
            'ROLE_ADMIN'
        );
        $usuariosComercial = $em->getRepository('AppBundle:Usuario')->findByRole(
            'ROLE_COMMERCIAL'
        );
        $usuariosCajero = $em->getRepository('AppBundle:Usuario')->findByRole(
            'ROLE_SELLER'
        );
        $usuariosProduccion = $em->getRepository('AppBundle:Usuario')->findByRole(
            'ROLE_PRODUCTION'
        );
        $usuariosDespacho = $em->getRepository('AppBundle:Usuario')->findByRole(
            'ROLE_SHIPPING'
        );

        return $this->render('usuario/index.html.twig', array(
            'usuariosAdmin' => $usuariosAdmin,
            'usuariosComercial' => $usuariosComercial,
            'usuariosProduccion' => $usuariosProduccion,
            'usuariosDespacho' => $usuariosDespacho,
            'usuariosCajero' => $usuariosCajero,
        ));
    }

    /**
     * Creates a new Usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /* === Asigna valores a contraseña y salt === */
            $salt = (base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
            $claveAleatoria = $this->container->get('app.twig_extension')->randomString();
            $password = $encoder->encodePassword($claveAleatoria, $salt);

            $usuario->setPassword($password);
            $usuario->setSalt($salt);

            $dominio=($request->request->get('dominioCorreo'));
            $nombre=$form['correo']->getData();
            $usuario->setCorreo($nombre.$dominio);

            $this->get('session')->getFlashBag()->set('info', "Contraseña de acceso es: ".$claveAleatoria);


            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('usuario_show', array('id' => $usuario->getId()));
        }

        return $this->render('usuario/new.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="usuario_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        if ($usuario->getRole() == 'ROLE_PRODUCTION') {
            $em = $this->getDoctrine()->getManager();
            $detalleCategorias = $em->getRepository('AppBundle:DetalleCategoria')->findAll();

            return $this->render('usuario/show.production.html.twig', array(
                'usuario' => $usuario,
                'detalleCategorias' => $detalleCategorias,
                'delete_form' => $deleteForm->createView(),
            ));
        }

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dominio=($request->request->get('dominioCorreo'));
            $nombre=$editForm['correo']->getData();
            $usuario->setCorreo($nombre.$dominio);

            $passwordCurrent = $request->request->get('text-pass-current');
            $passwordNew = $request->request->get('text-pass-new');

            if ($passwordCurrent != '' && $passwordNew != '') {

                $validate = $this->passValidateAction($passwordCurrent, $usuario);
                if ($validate == true) {
                    /* === Asigna valores a contraseña y salt === */
                    $salt = (base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
                    $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
                    $password = $encoder->encodePassword($passwordNew, $salt);
                    $usuario->setPassword($password);
                    $usuario->setSalt($salt);
                }else{
                    $this->get('session')->getFlashBag()->set('error', "La contraseña actual no es correcta");
                    return $this->redirectToRoute('usuario_show', array('id' => $usuario->getId()));
                }  
            }

            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('usuario_show', array('id' => $usuario->getId()));
                
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}", name="usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Creates a form to delete a Usuario entity.
     *
     * @param Usuario $usuario The Usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
