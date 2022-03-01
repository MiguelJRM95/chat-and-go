<?php

namespace App\Event\Usuario;

use App\Controller\Services\PerfilHandler;
use App\Entity\Usuario;
use App\Entity\Perfil;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class NuevoUsuarioEvent
{
    private $em;
    private $perfilHandler;

    public function __construct(EntityManagerInterface $em, PerfilHandler $perfilHandler)
    {
        $this->em = $em;
        $this->perfilHandler = $perfilHandler;
    }

    public function prePersist(Usuario $usuario, LifecycleEventArgs $event): void
    {
        $perfil = new Perfil();
        $avatar = $this->perfilHandler->fetchAvatar($usuario->getUsername());
        $perfil->setAvatar($avatar);
        $this->em->persist($perfil);
        $this->em->flush();
        $usuario->setPerfil($perfil);
    }
}
