<?php

namespace App\Controller\Api;

use App\Entity\Sala;
use App\Repository\SalaRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api", name="sala_api_")
 */
class SalaController extends AbstractController
{
    /** 
     * @Route("/salas_usuario/{usuario_id}", name="salas_usuario", methods={"GET"}, requirements={"usuario_id"="\d+"} )
     */
    public function salas(Request $req, UsuarioRepository $usuarioRepository, SerializerInterface $serializer): JsonResponse
    {
        try {
            $usuario = $usuarioRepository->findOneBy(["id" => $req->get('usuario_id')]);
            return JsonResponse::fromJsonString($serializer->serialize($usuario->getSalas(), 'json', ['groups' => ['sala']]), Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "El usuario no existe"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /** 
     * @Route("/salas_usuario/add", name="crear_sala", methods={"POST"} )
     */
    public function createSala(Request $req, UsuarioRepository $usuarioRepository, SalaRepository $salaRepository, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($req->getContent());

        $usuario = $usuarioRepository->findOneBy(["id" => $data->usuario_id]);

        $sala = new Sala();

        $sala->setNombreSala($data->nombre_sala);
        $sala->addUsuario($usuario);
        $usuario->addSala($sala);
        $em = $this->getDoctrine()->getManager();
        $em->persist($sala);
        $em->flush();

        return new JsonResponse(
            $data,
            Response::HTTP_CREATED
        );
    }

    /** 
     * @Route("/salas_usuario/add", name="crear_sala", methods={"POST"} )
     */
    public function addUserToSala(Request $req, UsuarioRepository $usuarioRepository, SalaRepository $salaRepository, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($req->getContent());

        $usuario = $usuarioRepository->findOneBy(["id" => $data->usuario_id]);

        $sala = new Sala();

        $sala->setNombreSala($data->nombre_sala);
        $sala->addUsuario($usuario);
        $usuario->addSala($sala);
        $em = $this->getDoctrine()->getManager();
        $em->persist($sala);
        $em->flush();

        return new JsonResponse(
            $data,
            Response::HTTP_CREATED
        );
    }
}
