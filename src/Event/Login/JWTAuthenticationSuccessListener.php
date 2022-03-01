<?php

namespace App\Event\Login;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JWTAuthenticationSuccessListener extends AbstractController
{

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {

        $user = $this->getUser();
        $payload = $event->getData();

        $payload['state'] = $user->getIsActive();
        $payload['username'] = $user->getUsername();
        $payload['perfil'] = array(
            'nombre' => $user->getPerfil()->getNombre(),
            'apellido_uno' => $user->getPerfil()->getApellidoUno(),
            'apellido_dos' => $user->getPerfil()->getApellidoDos(),
            'frase' => $user->getPerfil()->getFraseEstado(),
            'avatar' => $user->getPerfil()->getAvatar(),
            'address' => $user->getPerfil()->getDireccion()
        );

        $event->setData($payload);
    }
}
