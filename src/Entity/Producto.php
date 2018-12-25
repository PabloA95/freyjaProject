<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $codigo;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $precioEfectivo;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $precioTarjeta;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $precioCompra;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estado;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codigoBarra;

    /**
     * @ORM\ManyToOne(targetEntity="Marca", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="marca", referencedColumnName="id")
     */
    private $marca;

    /**
     * @ORM\ManyToOne(targetEntity="Descripcion", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="descripcion", referencedColumnName="id")
     */
    private $descripcion;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getPrecioEfectivo()
    {
        return $this->precioEfectivo;
    }

    public function setPrecioEfectivo($precioEfectivo): self
    {
        $this->precioEfectivo = $precioEfectivo;

        return $this;
    }

    public function getPrecioTarjeta()
    {
        return $this->precioTarjeta;
    }

    public function setPrecioTarjeta($precioTarjeta): self
    {
        $this->precioTarjeta = $precioTarjeta;

        return $this;
    }

    public function getPrecioCompra()
    {
        return $this->precioCompra;
    }

    public function setPrecioCompra($precioCompra): self
    {
        $this->precioCompra = $precioCompra;

        return $this;
    }

    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCodigoBarra(): ?int
    {
        return $this->codigoBarra;
    }

    public function setCodigoBarra(?int $codigoBarra): self
    {
        $this->codigoBarra = $codigoBarra;

        return $this;
    }

    public function getMarca(): ?Marca
    {
        return $this->marca;
    }

    public function setMarca(?Marca $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getDescripcion(): ?Descripcion
    {
        return $this->descripcion;
    }

    public function setDescripcion(?Descripcion $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
