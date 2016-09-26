<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleCategoria
 *
 * @ORM\Table(name="detalle_categoria")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DetalleCategoriaRepository")
 */
class DetalleCategoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UsuarioCategoria", mappedBy="detalleCategoria")
     **/
    private $usuarioCategoria;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Detalle", mappedBy="detalleCategoria")
     **/
    private $detalles;

    public function __construct() {
        $this->usuarioCategoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DetalleCategoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add usuarioCategoria
     *
     * @param \AppBundle\Entity\UsuarioCategoria $usuarioCategoria
     * @return DetalleCategoria
     */
    public function addUsuarioCategorium(\AppBundle\Entity\UsuarioCategoria $usuarioCategoria)
    {
        $this->usuarioCategoria[] = $usuarioCategoria;

        return $this;
    }

    /**
     * Remove usuarioCategoria
     *
     * @param \AppBundle\Entity\UsuarioCategoria $usuarioCategoria
     */
    public function removeUsuarioCategorium(\AppBundle\Entity\UsuarioCategoria $usuarioCategoria)
    {
        $this->usuarioCategoria->removeElement($usuarioCategoria);
    }

    /**
     * Get usuarioCategoria
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarioCategoria()
    {
        return $this->usuarioCategoria;
    }

    /**
     * Add detalles
     *
     * @param \AppBundle\Entity\Detalle $detalles
     * @return DetalleCategoria
     */
    public function addDetalle(\AppBundle\Entity\Detalle $detalles)
    {
        $this->detalles[] = $detalles;

        return $this;
    }

    /**
     * Remove detalles
     *
     * @param \AppBundle\Entity\Detalle $detalles
     */
    public function removeDetalle(\AppBundle\Entity\Detalle $detalles)
    {
        $this->detalles->removeElement($detalles);
    }

    /**
     * Get detalles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetalles()
    {
        return $this->detalles;
    }
}
