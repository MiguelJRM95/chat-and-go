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
     * @Route("/salas_usuario/{sala_id}", name="eliminar_sala", methods={"DELETE"}, requirements={"sala_id"="\d+"} )
     */
    public function removeSala(Request $req, SalaRepository $salaRepository): JsonResponse
    {
        try {
            $sala = $salaRepository->findOneBy(["id" => $req->get("sala_id")]);
            $sala_id = $sala->getId();
            $sala_nombre = $sala->getNombreSala();

            $em = $this->getDoctrine()->getManager();
            $em->remove($sala);
            $em->flush();

            return new JsonResponse(
                ["success" => "Sala $sala_id con nombre $sala_nombre ha sido eliminada con exito"],
                Response::HTTP_OK
            );
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "No se ha podido eliminar la sala"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /** 
     * @Route("/salas_usuario/add", name="crear_sala", methods={"POST"} )
     */
    public function createSala(Request $req, UsuarioRepository $usuarioRepository, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($req->getContent());

        $usuario = $usuarioRepository->findOneBy(["id" => $data->usuario_id]);

        if ($usuario === null) {
            return new JsonResponse(
                ["error" => "El usuario no existe"],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $sala = new Sala();

            $sala->setNombreSala($data->nombre_sala);
            $sala->addUsuario($usuario);
            $usuario->addSala($sala);
            $em = $this->getDoctrine()->getManager();
            $em->persist($sala);
            $em->flush();

            return JsonResponse::fromJsonString($serializer->serialize($sala, 'json', ['groups' => ['sala']]), Response::HTTP_CREATED);
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "No se ha podido crear la sala"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /** 
     * @Route("/salas_usuario/addUser", name="aniadir_usuario_sala", methods={"PUT"} )
     */
    public function addUsuario(Request $req, UsuarioRepository $usuarioRepository, SalaRepository $salaRepository, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($req->getContent());

        $usuario = $usuarioRepository->findOneBy(["id" => $data->usuario_id]);

        if ($usuario === null) {
            return new JsonResponse(
                ["error" => "El usuario no existe"],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $sala = $salaRepository->findOneBy(["id" => $data->sala_id]);

            $sala->addUsuario($usuario);
            $usuario->addSala($sala);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return JsonResponse::fromJsonString($serializer->serialize($sala, 'json', ['groups' => ['sala']]), Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "No se ha podido añadir el usuario a la sala"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /** 
     * @Route("/salas_usuario/removeUser", name="eliminar_usuario_sala", methods={"PUT"} )
     */
    public function removeUsuario(Request $req, UsuarioRepository $usuarioRepository, SalaRepository $salaRepository, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($req->getContent());

        $usuario = $usuarioRepository->findOneBy(["id" => $data->usuario_id]);

        if ($usuario === null) {
            return new JsonResponse(
                ["error" => "El usuario no existe"],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $sala = $salaRepository->findOneBy(["id" => $data->sala_id]);

            $sala->removeUsuario($usuario);
            $usuario->removeSala($sala);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return JsonResponse::fromJsonString($serializer->serialize($sala, 'json', ['groups' => ['sala']]), Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "No se ha podido eliminar el usuario a la sala"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
