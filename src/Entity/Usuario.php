<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"usuario","sala"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"usuario","sala"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Mensaje::class, mappedBy="usuario_emisor", orphanRemoval=true)
     */
    private $mensajes_enviados;

    /**
     * @ORM\OneToMany(targetEntity=Mensaje::class, mappedBy="usuario_receptor", orphanRemoval=true)
     */
    private $mensajes_recibidos;

    /**
     * @ORM\ManyToMany(targetEntity=Sala::class, inversedBy="usuarios")
     * @ORM\JoinTable(name="usuarios_salas")
     * @Groups({"usuario"})
     */
    private $salas;

    /**
     * @ORM\ManyToMany(targetEntity=Usuario::class, mappedBy="amigos_conmigo")
     */
    private $mis_amigos;

    /**
     * @ORM\ManyToMany(targetEntity=Usuario::class, inversedBy="mis_amigos")
     * @ORM\JoinTable(name="amigos",
     *      joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="amigo_usuario_id", referencedColumnName="id")}
     *      )
     */
    private $amigos_conmigo;

    /**
     * @ORM\OneToOne(targetEntity=Perfil::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $perfil;

    /**
     * @ORM\OneToMany(targetEntity=Peticion::class, mappedBy="usuario_receptor", orphanRemoval=true)
     */
    private $peticiones_recibidas;

    /**
     * @ORM\OneToMany(targetEntity=Peticion::class, mappedBy="usuario_emisor", orphanRemoval=true)
     */
    private $peticiones_enviadas;

    public function __construct()
    {
        $this->mensajes_enviados = new ArrayCollection();
        $this->mensajes_recibidos = new ArrayCollection();
        $this->salas = new ArrayCollection();
        $this->mis_amigos = new ArrayCollection();
        $this->amigos_conmigo = new ArrayCollection();
        $this->peticiones_recibidas = new ArrayCollection();
        $this->peticiones_enviadas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Mensaje[]
     */
    public function getMensajesEnviados(): Collection
    {
        return $this->mensajes_enviados;
    }

    public function addMensajesEnviado(Mensaje $mensajesEnviado): self
    {
        if (!$this->mensajes_enviados->contains($mensajesEnviado)) {
            $this->mensajes_enviados[] = $mensajesEnviado;
            $mensajesEnviado->setUsuarioEmisor($this);
        }

        return $this;
    }

    public function removeMensajesEnviado(Mensaje $mensajesEnviado): self
    {
        if ($this->mensajes_enviados->removeElement($mensajesEnviado)) {
            // set the owning side to null (unless already changed)
            if ($mensajesEnviado->getUsuarioEmisor() === $this) {
                $mensajesEnviado->setUsuarioEmisor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mensaje[]
     */
    public function getMensajesRecibidos(): Collection
    {
        return $this->mensajes_recibidos;
    }

    public function addMensajesRecibido(Mensaje $mensajesRecibido): self
    {
        if (!$this->mensajes_recibidos->contains($mensajesRecibido)) {
            $this->mensajes_recibidos[] = $mensajesRecibido;
            $mensajesRecibido->setUsuarioReceptor($this);
        }

        return $this;
    }

    public function removeMensajesRecibido(Mensaje $mensajesRecibido): self
    {
        if ($this->mensajes_recibidos->removeElement($mensajesRecibido)) {
            // set the owning side to null (unless already changed)
            if ($mensajesRecibido->getUsuarioReceptor() === $this) {
                $mensajesRecibido->setUsuarioReceptor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sala[]
     * @Groups({"usuario","salas"})
     */
    public function getSalas(): Collection
    {
        return $this->salas;
    }

    public function addSala(Sala $sala): self
    {
        if (!$this->salas->contains($sala)) {
            $this->salas[] = $sala;
            $sala->addUsuario($this);
        }

        return $this;
    }

    public function removeSala(Sala $sala): self
    {
        if ($this->salas->removeElement($sala)) {
            $sala->removeUsuario($this);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMisAmigos(): Collection
    {
        return $this->mis_amigos;
    }

    public function addMisAmigo(self $misAmigo): self
    {
        if (!$this->mis_amigos->contains($misAmigo)) {
            $this->mis_amigos[] = $misAmigo;
        }

        return $this;
    }

    public function removeMisAmigo(self $misAmigo): self
    {
        $this->mis_amigos->removeElement($misAmigo);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getAmigosConmigo(): Collection
    {
        return $this->amigos_conmigo;
    }

    public function addAmigosConmigo(self $amigosConmigo): self
    {
        if (!$this->amigos_conmigo->contains($amigosConmigo)) {
            $this->amigos_conmigo[] = $amigosConmigo;
            $amigosConmigo->addMisAmigo($this);
        }

        return $this;
    }

    public function removeAmigosConmigo(self $amigosConmigo): self
    {
        if ($this->amigos_conmigo->removeElement($amigosConmigo)) {
            $amigosConmigo->removeMisAmigo($this);
        }

        return $this;
    }

    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(Perfil $perfil): self
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * @return Collection|Peticion[]
     */
    public function getPeticionesRecibidas(): Collection
    {
        return $this->peticiones_recibidas;
    }

    public function addPeticionesRecibida(Peticion $peticionesRecibida): self
    {
        if (!$this->peticiones_recibidas->contains($peticionesRecibida)) {
            $this->peticiones_recibidas[] = $peticionesRecibida;
            $peticionesRecibida->setUsuarioReceptor($this);
        }

        return $this;
    }

    public function removePeticionesRecibida(Peticion $peticionesRecibida): self
    {
        if ($this->peticiones_recibidas->removeElement($peticionesRecibida)) {
            // set the owning side to null (unless already changed)
            if ($peticionesRecibida->getUsuarioReceptor() === $this) {
                $peticionesRecibida->setUsuarioReceptor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Peticion[]
     */
    public function getPeticionesEnviadas(): Collection
    {
        return $this->peticiones_enviadas;
    }

    public function addPeticionesEnviada(Peticion $peticionesEnviada): self
    {
        if (!$this->peticiones_enviadas->contains($peticionesEnviada)) {
            $this->peticiones_enviadas[] = $peticionesEnviada;
            $peticionesEnviada->setUsuarioEmisor($this);
        }

        return $this;
    }

    public function removePeticionesEnviada(Peticion $peticionesEnviada): self
    {
        if ($this->peticiones_enviadas->removeElement($peticionesEnviada)) {
            // set the owning side to null (unless already changed)
            if ($peticionesEnviada->getUsuarioEmisor() === $this) {
                $peticionesEnviada->setUsuarioEmisor(null);
            }
        }

        return $this;
    }
}
