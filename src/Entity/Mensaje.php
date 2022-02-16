<?php

namespace App\Entity;

use App\Repository\MensajeRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MensajeRepository::class)
 */
class Mensaje
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"sala", "usuario"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"sala", "usuario"})
     */
    private $contenido;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"sala", "usuario"})
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"sala", "usuario"})
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="mensajes_enviados")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"sala"})
     */
    private $usuario_emisor;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="mensajes_recibidos")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"sala"})
     */
    private $usuario_receptor;

    /**
     * @ORM\ManyToOne(targetEntity=Sala::class, inversedBy="mensajes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sala;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenido(): ?string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): self
    {
        $this->contenido = $contenido;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

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

    public function getUsuarioReceptor(): ?Usuario
    {
        return $this->usuario_receptor;
    }

    public function setUsuarioReceptor(?Usuario $usuario_receptor): self
    {
        $this->usuario_receptor = $usuario_receptor;

        return $this;
    }

    public function getSala(): ?Sala
    {
        return $this->sala;
    }

    public function setSala(?Sala $sala): self
    {
        $this->sala = $sala;

        return $this;
    }
}
