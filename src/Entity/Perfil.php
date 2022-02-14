<?php

namespace App\Entity;

use App\Repository\PerfilRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PerfilRepository::class)
 */
class Perfil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apellido_uno;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apellido_dos;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $frase_estado;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direccion;

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

    public function getApellidoUno(): ?string
    {
        return $this->apellido_uno;
    }

    public function setApellidoUno(string $apellido_uno): self
    {
        $this->apellido_uno = $apellido_uno;

        return $this;
    }

    public function getApellidoDos(): ?string
    {
        return $this->apellido_dos;
    }

    public function setApellidoDos(string $apellido_dos): self
    {
        $this->apellido_dos = $apellido_dos;

        return $this;
    }

    public function getFraseEstado(): ?string
    {
        return $this->frase_estado;
    }

    public function setFraseEstado(?string $frase_estado): self
    {
        $this->frase_estado = $frase_estado;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }
}
