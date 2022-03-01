<?php

namespace App\Controller\Api;

use App\Repository\MensajeRepository;
use App\Repository\SalaRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api", name="mensaje_api_")
 */
class MensajeController extends AbstractController
{

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA TODOS LOS MENSAJES (solo admin)+++++++++++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/messages", name="mensajes_all", methods={"GET"} )
     */
    public function mensajesAll(SerializerInterface $serializer, MensajeRepository $mensajeRepository): JsonResponse
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(
                ["error" => "Solo los administradores pueden ver todos los mensajes"],
                Response::HTTP_FORBIDDEN
            );
        }

        $mensajesRecibidos = $mensajeRepository->findAll();
        return JsonResponse::fromJsonString($serializer->serialize($mensajesRecibidos, 'json', ['groups' => ['mensaje']]), Response::HTTP_OK);
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA LOS MENSAJES RECIBIDOS POR EL USUARIO LOGUEADO++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/messages_recieved", name="mensajes_recibidos", methods={"GET"} )
     */
    public function mensajesRecibidos(SerializerInterface $serializer): JsonResponse
    {
        $mensajesRecibidos = $this->getUser()->getMensajesRecibidos();
        return JsonResponse::fromJsonString($serializer->serialize($mensajesRecibidos, 'json', ['groups' => ['mensaje']]), Response::HTTP_OK);
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA LOS MENSAJES RECIBIDOS EN X SALA EL USUARIO LOGUEADO++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/messages_recieved_by_sala", name="mensajes_recibidos_sala", methods={"GET"} )
     */
    public function mensajesRecibidosSala(SerializerInterface $serializer, UsuarioRepository $usuarioRepository, SalaRepository $salaRepository): JsonResponse
    {
        //$usuario = $this->getUser();

        $sala = $salaRepository->findOneBy(['id' => 2]);

        $mensajes = $usuarioRepository->findMensajesRecibidosBySala($sala);

        return JsonResponse::fromJsonString($serializer->serialize($mensajes, 'json', ['groups' => ['mensaje_recibido']]), Response::HTTP_OK);
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA LOS MENSAJES ENVIADOS POR EL USUARIO LOGUEADO+++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/messages_sended", name="mensajes_enviados", methods={"GET"} )
     */
    public function mensajesEnviados(SerializerInterface $serializer): JsonResponse
    {
        $mensajesEnviados = $this->getUser()->getMensajesEnviados();
        return JsonResponse::fromJsonString($serializer->serialize($mensajesEnviados, 'json', ['groups' => ['mensaje']]), Response::HTTP_OK);
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * +++++LISTA LOS MENSAJES ENVIADOS EN X SALA POR EL USUARIO LOGUEADO++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/messages_sended_by_sala", name="mensajes_enviados_sala", methods={"GET"} )
     */
    public function mensajesEnviadosSala(SerializerInterface $serializer, UsuarioRepository $usuarioRepository, SalaRepository $salaRepository): JsonResponse
    {
        $sala = $salaRepository->findOneBy(['id' => 2]);

        $mensajes = $usuarioRepository->findMensajesEnviadosBySala($sala);

        return JsonResponse::fromJsonString($serializer->serialize($mensajes, 'json', ['groups' => ['mensaje_enviado']]), Response::HTTP_OK);
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++ENVIA UN MENSAJE CON EL USUARIO LOGUEADO++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/send_message", name="enviar_mensaje", methods={"POST"} )
     */
    public function enviarMensaje(SerializerInterface $serializer): JsonResponse
    {
        $mensajesEnviados = $this->getUser()->getMensajesEnviados();
        return JsonResponse::fromJsonString($serializer->serialize($mensajesEnviados, 'json', ['groups' => ['mensaje']]), Response::HTTP_OK);
    }
}
