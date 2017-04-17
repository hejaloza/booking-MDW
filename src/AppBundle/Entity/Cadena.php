<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cadena
 *
 * @ORM\Table(name="cadena")
 * @ORM\Entity
 */
class Cadena
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="logotipo", type="string", length=100, nullable=false)
     */
    private $logotipo;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=100, nullable=false)
     */
    private $responsable;



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
     *
     * @return Cadena
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
     * Set logotipo
     *
     * @param string $logotipo
     *
     * @return Cadena
     */
    public function setLogotipo($logotipo)
    {
        $this->logotipo = $logotipo;

        return $this;
    }

    /**
     * Get logotipo
     *
     * @return string
     */
    public function getLogotipo()
    {
        return $this->logotipo;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Cadena
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }
}
