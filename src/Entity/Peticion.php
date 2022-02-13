<?php

namespace App\Entity;

use App\Repository\PeticionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeticionRepository::class)
 */
class Peticion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="peticiones_recibidas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario_receptor;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="peticiones_enviadas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario_emisor;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsuarioReceptor(): ?Usuario
    {
        return $this->usuario_receptor;
    }

    public function setUsuarioReceptor(?Usuario $usuario_receptor): self
    {
        $this->usuario_receptor = $usuario_receptor;

        return $this;
    }

    public function getUsuarioEmisor(): ?Usuario
    {
        return $this->usuario_emisor;
    }

    public function setUsuarioEmisor(?Usuario $usuario_emisor): self
    {
        $this->usuario_emisor = $usuario_emisor;

        return $this;
    }
}
