<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prioridad
 *
 * @ORM\Table(name="prioridad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrioridadRepository")
 */
class Prioridad
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=10)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="rango", type="string", length=100)
     */
    private $rango;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccion", mappedBy="prioridad")
     **/
    private $ordenProduccion;

    public function __construct() {
        $this->ordenProduccion = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Prioridad
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
     * Set color
     *
     * @param string $color
     * @return Prioridad
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set rango
     *
     * @param string $rango
     * @return Prioridad
     */
    public function setRango($rango)
    {
        $this->rango = $rango;

        return $this;
    }

    /**
     * Get rango
     *
     * @return string 
     */
    public function getRango()
    {
        return $this->rango;
    }

    /**
     * Add ordenProduccion
     *
     * @param \AppBundle\Entity\OrdenProduccion $ordenProduccion
     * @return Prioridad
     */
    public function addOrdenProduccion(\AppBundle\Entity\OrdenProduccion $ordenProduccion)
    {
        $this->ordenProduccion[] = $ordenProduccion;

        return $this;
    }

    /**
     * Remove ordenProduccion
     *
     * @param \AppBundle\Entity\OrdenProduccion $ordenProduccion
     */
    public function removeOrdenProduccion(\AppBundle\Entity\OrdenProduccion $ordenProduccion)
    {
        $this->ordenProduccion->removeElement($ordenProduccion);
    }

    /**
     * Get ordenProduccion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrdenProduccion()
    {
        return $this->ordenProduccion;
    }
}
