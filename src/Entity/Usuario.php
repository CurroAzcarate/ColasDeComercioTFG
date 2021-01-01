<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;




/**
 * 
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface
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
     * @ORM\Column(name="role", type="string", length=50, nullable=true)
     */
    private $role;
    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z ]+/")
     */
    private $name;
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", length=200, nullable=false)
     * 
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z ]+/")
     */
    private $surname;
    
    /**
     * @var string|null
     * @ORM\Column(name="email", type="string", length=255, nullable=false,unique=true)
    
     * @Assert\Email(
     *      message="el email '{{ value }}' no es válido",
     *      checkMX=true
     * )
     * @Assert\NotBlank
     */
    private $email;
     /**
     * @var string|null
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $password;
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=false)
     */
    private $createAt;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Negocio" ,mappedBy="usuario")
     */
    private $negocio;
    
     /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Tiquet" ,mappedBy="usuario")
     */
    private $tiquet;

    public function __construct()
    {
        $this->negocio = new ArrayCollection();
        $this->tiquet = new ArrayCollection();
    }
    
   
     /**
   * @CaptchaAssert\ValidCaptcha(
   *      message = "CAPTCHA validation failed, try again."
   * )
   */
    
  protected $captchaCode;

  public function getCaptchaCode()
  {
    return $this->captchaCode;
  }

  public function setCaptchaCode($captchaCode)
  {
    $this->captchaCode = $captchaCode;
  }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    /**
     * @return Collection|Negocio[]
     */
    public function getNegocio(): Collection
    {
        return $this->negocio;
    }

    public function addNegocio(Negocio $negocio): self
    {
        if (!$this->negocio->contains($negocio)) {
            $this->negocio[] = $negocio;
            $negocio->setUsuario($this);
        }

        return $this;
    }

    public function removeNegocio(Negocio $negocio): self
    {
        if ($this->negocio->contains($negocio)) {
            $this->negocio->removeElement($negocio);
            // set the owning side to null (unless already changed)
            if ($negocio->getUsuario() === $this) {
                $negocio->setUsuario(null);
            }
        }

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
            $tiquet->setUsuario($this);
        }

        return $this;
    }

    public function removeTiquet(Tiquet $tiquet): self
    {
        if ($this->tiquet->contains($tiquet)) {
            $this->tiquet->removeElement($tiquet);
            // set the owning side to null (unless already changed)
            if ($tiquet->getUsuario() === $this) {
                $tiquet->setUsuario(null);
            }
        }

        return $this;
    }
    
    public function getUsername(){
        return $this->email;
    }

    public function getSalt(){
        return null;
    }
    
    public function getRoles(){
        return array($this->getRole());
    }
    
    public function eraseCredentials(){}
    
}
