<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Usuario;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NegocioRepository")
 */
class Negocio
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
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     * 
     * @Assert\NotBlank
     * 
     */
    private $nombre;
    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=300, nullable=false)
     * 
     * @Assert\NotBlank
     *
     */
    private $descripcion;
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=false)
     */
    private $createAt;
    
    
    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario",inversedBy="negocio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;
    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Tiquet" ,mappedBy="negocio")
     */
    private $tiquet;

    public function __construct()
    {
        $this->tiquet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    /**
     * @return Collection|Tiquet[]
     */
    public function getTiquet(): Collection
    {
        return $this->tiquet;
    }

    public function addTiquet(Tiquet $tiquet): self
    {
        if (!$this->tiquet->contains($tiquet)) {
            $this->tiquet[] = $tiquet;
            $tiquet->setNegocio($this);
            
        }

        return $this;
    }

    public function removeTiquet(Tiquet $tiquet): self
    {
        if ($this->tiquet->contains($tiquet)) {
            $this->tiquet->removeElement($tiquet);
            // set the owning side to null (unless already changed)
            if ($tiquet->getNegocio() === $this) {
                $tiquet->setNegocio(null);
            }
        }

        return $this;
    }
}
