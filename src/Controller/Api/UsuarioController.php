<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api", name="user_api_")
 */
class UsuarioController extends AbstractController
{
    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++++++++++++++ACTUALIZA EL PERFIL DEL USUARIO+++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/update_profile", name="actualizar_perfil", methods={"PUT"} )
     */
    public function updatePerfil(Request $req): JsonResponse
    {
        //TODO FORMULARIO MENOS AVATAR
        //PROCESAR REQUEST
        //DEVOLVER PERFIL ACTUALIZADO
        return new JsonResponse('hello');
    }
}
