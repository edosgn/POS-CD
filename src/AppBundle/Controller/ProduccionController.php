<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Pedido;
use AppBundle\Entity\OrdenProduccion;
use AppBundle\Entity\Usuario;

/**
 * Produccion controller.
 *
 * @Route("/produccion")
 */
class ProduccionController extends Controller
{
    /**
     * ingreso inicial a perfl produccion.
     *
     * @Route("/", name="produccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('produccion/index.html.twig');
    }    

    /**
     * Lista las ordenes de produccion asignadas al usuario en cuestion.
     *
     * @Route("/{user}", name="produccion_list")
     * @Method("GET")
     */
    public function listarAction(Usuario $user)
    {
    	$em = $this->getDoctrine()->getManager();
    	$nombre=$user->__toString();

        $ordenes = $em->getRepository('AppBundle:Pedido')->findOrdenesByUsuario($nombre);

        return $this->render('produccion/list.html.twig', array(
            'ordenes' => $ordenes,
        ));
    }

    /**
     * Finds and displays a OrdenProduccion entity.
     *
     * @Route("/ver/{id}", name="produccion_ver")
     * @Method("GET")
     */
    public function verAction(OrdenProduccion $ordenProduccion)
    {
        $deleteForm = $this->createDeleteForm($ordenProduccion);
        $pedido=$ordenProduccion->getPedido();

        return $this->render('produccion/ver.html.twig', array(
            'ordenProduccion' => $ordenProduccion,
            'pedido' => $pedido,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a OrdenProduccion entity.
     *
     * @Route("/aceptar/{id}", name="produccion_aceptar")
     * @Method("GET")
     */
    public function aceptarAction(OrdenProduccion $ordenProduccion)
    {
        $deleteForm = $this->createDeleteForm($ordenProduccion);
    	$em = $this->getDoctrine()->getManager();
        $ordenProduccion->setEstado('En Proceso');
        $em->persist($ordenProduccion);
        $em->flush();

        return $this->render('produccion/ver.html.twig', array(
            'ordenProduccion' => $ordenProduccion,  
            'delete_form' => $deleteForm->createView(),         
        ));
    }

    /**
     * Finds and displays a OrdenProduccion entity.
     *
     * @Route("/finalizar/{id}", name="produccion_finalizar")
     * @Method("GET")
     */
    public function finalizarAction(OrdenProduccion $ordenProduccion)
    {
    	$em = $this->getDoctrine()->getManager();
        $ordenProduccion->setEstado('Listo');
        $em->persist($ordenProduccion);
        $em->flush();
        $usuario=$this->get('security.context')->getToken()->getUser();

        $ordenesFinalizadas=$em->getRepository('AppBundle:Pedido')->findByFinalizadas($usuario->__toString(),'Listo');

        return $this->render('produccion/finalizadas.html.twig', array(
            'ordenes' => $ordenesFinalizadas, 
            'user' => $usuario,            
        ));
    }


    /**
     * Lista las ordenes de produccion finalizadas por el usuario.
     *
     * @Route("/finalizadas/{user}", name="produccion_finalizadas")
     * @Method("GET")
     */
    public function finalizadaAction(Usuario $user)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre=$user->__toString();

        $ordenes = $em->getRepository('AppBundle:Pedido')->findByFinalizadas($nombre,'Listo');;

        return $this->render('produccion/finalizadas.html.twig', array(
            'ordenes' => $ordenes,
            'user' => $user,
        ));
    }


    /**
     * Creates a form to delete a OrdenProduccion entity.
     *
     * @param OrdenProduccion $ordenProduccion The OrdenProduccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrdenProduccion $ordenProduccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orden_produccion_delete', array('id' => $ordenProduccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}