<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TiquetRepository")
 */
class Tiquet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string|null
     *
     * @ORM\Column(name="codigo", type="string", length=100, nullable=false,unique=true)
     * 
     */
    private $codigo;
    /**
     * @var string|null
     *
     * @ORM\Column(name="estado", type="string", length=100, nullable=false)
     *
     */
    private $estado;
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=false)
     */
    private $createAt;
    
    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario",inversedBy="tiquet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;
    
    /**
     * @var \Negocio
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Negocio",inversedBy="tiquet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="negocio_id", referencedColumnName="id")
     * })
     */
    private $negocio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getNegocio(): ?Negocio
    {
        return $this->negocio;
    }

    public function setNegocio(?Negocio $negocio): self
    {
        $this->negocio = $negocio;

        return $this;
    }
    
    
    
}
