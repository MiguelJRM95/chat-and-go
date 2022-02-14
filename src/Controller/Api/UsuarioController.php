<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsuarioRepository;
use App\Repository\PerfilRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api", name="user_api")
 */
class UsuarioController extends AbstractController
{
    private $usuarioRepository;
    private $perfilRepository;

    public function __construct(UsuarioRepository $usuarioRepository, PerfilRepository $perfilRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->perfilRepository = $perfilRepository;
    }



    /** 
     * @Route("/update_profile/{user_id}", name="update_profile", methods={"PUT"} )
     */
    public function updatePerfil(Request $req): JsonResponse
    {

        return new JsonResponse('hello');
    }
}
