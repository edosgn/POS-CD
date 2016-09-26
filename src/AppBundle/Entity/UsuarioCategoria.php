<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioCategoria
 *
 * @ORM\Table(name="usuario_categoria")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioCategoriaRepository")
 */
class UsuarioCategoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="usuarioCategoria") */
    protected $responsable;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\DetalleCategoria", inversedBy="usuarioCategoria") */
    protected $detalleCategoria;


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
     * Set responsable
     *
     * @param \AppBundle\Entity\Usuario $responsable
     * @return UsuarioCategoria
     */
    public function setResponsable(\AppBundle\Entity\Usuario $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set detalleCategoria
     *
     * @param \AppBundle\Entity\DetalleCategoria $detalleCategoria
     * @return UsuarioCategoria
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
}
