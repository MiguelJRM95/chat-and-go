<?php

namespace App\Controller\Api;

use App\Repository\SalaRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api", name="sala_api_")
 */
class SalaController extends AbstractController
{
    /** 
     * @Route("/salas_usuario/{usuario_id}", name="salas", methods={"GET"} )
     */
    public function salas(Request $req, SalaRepository $salaRepository, UsuarioRepository $usuarioRepository, SerializerInterface $serializer): JsonResponse
    {
        $usuario = $usuarioRepository->findOneBy(["id" => 1]);
        //dd($usuario->getId());
        //$salas = $salaRepository->findBy(["usuarios" => [$usuario->getId()]]);
        dd($serializer->serialize($usuario, 'json', ['groups' => ['usuario']]));
        return new JsonResponse($usuario);
    }
}
