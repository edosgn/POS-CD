<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mensaje
 *
 * @ORM\Table(name="mensaje")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MensajeRepository")
 */
class Mensaje
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
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\MensajeCategoria", inversedBy="mensajes") */
    protected $mensajeCategoria;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccion", mappedBy="mensaje")
     **/
    private $ordenProduccion;

    public function __construct() {
        $this->ordenProduccion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getDescripcion();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Mensaje
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
     * Set mensajeCategoria
     *
     * @param \AppBundle\Entity\MensajeCategoria $mensajeCategoria
     * @return Mensaje
     */
    public function setMensajeCategoria(\AppBundle\Entity\MensajeCategoria $mensajeCategoria = null)
    {
        $this->mensajeCategoria = $mensajeCategoria;

        return $this;
    }

    /**
     * Get mensajeCategoria
     *
     * @return \AppBundle\Entity\MensajeCategoria 
     */
    public function getMensajeCategoria()
    {
        return $this->mensajeCategoria;
    }

    /**
     * Add ordenProduccionDetalle
     *
     * @param \AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle
     * @return Mensaje
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
