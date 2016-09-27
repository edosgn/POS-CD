<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalle
 *
 * @ORM\Table(name="detalle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DetalleRepository")
 */
class Detalle
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="precio_base", type="bigint")
     */
    private $precioBase;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\DetalleCategoria", inversedBy="detalles") */
    protected $detalleCategoria;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccionDetalle", mappedBy="detalle")
     **/
    private $ordenProduccionDetalle;

     

    public function __construct() {
        $this->ordenProduccionDetalle = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Detalle
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Detalle
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

   
    /**
     * Set precioBase
     *
     * @param integer $precioBase
     * @return Detalle
     */
    public function setPrecioBase($precioBase)
    {
        $this->precioBase = $precioBase;

        return $this;
    }

    /**
     * Get precioBase
     *
     * @return integer 
     */
    public function getPrecioBase()
    {
        return $this->precioBase;
    }

    /**
     * Set detalleCategoria
     *
     * @param \AppBundle\Entity\DetalleCategoria $detalleCategoria
     * @return Detalle
     */
    public function setDetalleCategoria(\AppBundle\Entity\DetalleCategoria $detalleCategoria = null)
    {
        $this->detalleCategoria = $detalleCategoria;

        return $this;
    }

    /**
     * Get detalleCategoria
     *
     * @return \AppBundle\Entity\DetalleCategoria 
     */
    public function getDetalleCategoria()
    {
        return $this->detalleCategoria;
    }

    /**
     * Add ordenProduccionDetalle
     *
     * @param \AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle
     * @return Detalle
     */
    public function addOrdenProduccionDetalle(\AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle)
    {
        $this->ordenProduccionDetalle[] = $ordenProduccionDetalle;

        return $this;
    }

    /**
     * Remove ordenProduccionDetalle
     *
     * @param \AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle
     */
    public function removeOrdenProduccionDetalle(\AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle)
    {
        $this->ordenProduccionDetalle->removeElement($ordenProduccionDetalle);
    }

    /**
     * Get ordenProduccionDetalle
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrdenProduccionDetalle()
    {
        return $this->ordenProduccionDetalle;
    }

 
}
