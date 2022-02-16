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
     * @Route("/update_profile/{user_id}", name="update_profile", methods={"PUT"} )
     */
    public function updatePerfil(Request $req): JsonResponse
    {

        return new JsonResponse('hello');
    }
}
