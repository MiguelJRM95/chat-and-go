<?php

namespace App\Entity;

use App\Repository\SalaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalaRepository::class)
 */
class Sala
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
    private $nombre_sala;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":1})
     * @Groups({"sala", "usuario"})
     */
    private $estado = 1;

    /**
     * @ORM\ManyToMany(targetEntity=Usuario::class, mappedBy="salas")
     * @ORM\JoinTable(name="usuarios_salas")
     */
    private $usuarios;

    /**
     * @ORM\OneToMany(targetEntity=Mensaje::class, mappedBy="sala", orphanRemoval=true)
     * @Groups({"sala", "usuario"})
     */
    private $mensajes;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->mensajes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreSala(): ?string
    {
        return $this->nombre_sala;
    }

    public function setNombreSala(string $nombre_sala): self
    {
        $this->nombre_sala = $nombre_sala;

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

    /**
     * @return Collection|Usuario[]
     * @Groups({"sala"})
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): self
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios[] = $usuario;
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): self
    {
        $this->usuarios->removeElement($usuario);

        return $this;
    }

    /**
     * @return Collection|Mensaje[]
     */
    public function getMensajes(): Collection
    {
        return $this->mensajes;
    }

    public function addMensaje(Mensaje $mensaje): self
    {
        if (!$this->mensajes->contains($mensaje)) {
            $this->mensajes[] = $mensaje;
            $mensaje->setSala($this);
        }

        return $this;
    }

    public function removeMensaje(Mensaje $mensaje): self
    {
        if ($this->mensajes->removeElement($mensaje)) {
            // set the owning side to null (unless already changed)
            if ($mensaje->getSala() === $this) {
                $mensaje->setSala(null);
            }
        }

        return $this;
    }
}
