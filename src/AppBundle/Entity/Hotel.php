<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hotel
 *
 * @ORM\Table(name="hotel", indexes={@ORM\Index(name="id_cadena", columns={"id_cadena"})})
 * @ORM\Entity
 */
class Hotel
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
     * @ORM\Column(name="direccion", type="string", length=100, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=100, nullable=false)
     */
    private $responsable;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_hora", type="float", precision=10, scale=0, nullable=false)
     */
    private $precioHora;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigo_postal", type="integer", nullable=false)
     */
    private $codigoPostal;

    /**
     * @var integer
     *
     * @ORM\Column(name="min_horas", type="integer", nullable=false)
     */
    private $minHoras;

    /**
     * @var \Cadena
     *
     * @ORM\ManyToOne(targetEntity="Cadena")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cadena", referencedColumnName="id")
     * })
     */
    private $idCadena;



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
     * @return Hotel
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Hotel
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Hotel
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

    /**
     * Set precioHora
     *
     * @param float $precioHora
     *
     * @return Hotel
     */
    public function setPrecioHora($precioHora)
    {
        $this->precioHora = $precioHora;

        return $this;
    }

    /**
     * Get precioHora
     *
     * @return float
     */
    public function getPrecioHora()
    {
        return $this->precioHora;
    }

    /**
     * Set codigoPostal
     *
     * @param integer $codigoPostal
     *
     * @return Hotel
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return integer
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set minHoras
     *
     * @param integer $minHoras
     *
     * @return Hotel
     */
    public function setMinHoras($minHoras)
    {
        $this->minHoras = $minHoras;

        return $this;
    }

    /**
     * Get minHoras
     *
     * @return integer
     */
    public function getMinHoras()
    {
        return $this->minHoras;
    }

    /**
     * Set idCadena
     *
     * @param \AppBundle\Entity\Cadena $idCadena
     *
     * @return Hotel
     */
    public function setIdCadena(\AppBundle\Entity\Cadena $idCadena = null)
    {
        $this->idCadena = $idCadena;

        return $this;
    }

    /**
     * Get idCadena
     *
     * @return \AppBundle\Entity\Cadena
     */
    public function getIdCadena()
    {
        return $this->idCadena;
    }
}
