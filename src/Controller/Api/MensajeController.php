<?php

namespace App\Controller\Api;

use App\Entity\Mensaje;
use App\Repository\MensajeRepository;
use App\Repository\SalaRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api", name="mensaje_api_")
 */
class MensajeController extends AbstractController
{

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA TODOS LOS MENSAJES (solo admin)+++++++++++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @OA\Response(
     *     response=200,
     *     description="Devuelve los mensajes de todos los usuarios, solo admins",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mensaje::class, groups={"mensaje"}))
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Lanza error si no se es administrador",
     * )
     * @OA\Tag(name="mensaje")
     * @Security(name="Bearer")
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
     * @OA\Response(
     *     response=200,
     *     description="Devuelve los mensajes recibidos de todas las salas",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mensaje::class, groups={"mensaje"}))
     *     )
     * )
     * @OA\Tag(name="mensaje")
     * @Security(name="Bearer")
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
     *  @OA\Response(
     *     response=200,
     *     description="Devuelve los mensajes recibidos en la sala",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mensaje::class, groups={"mensaje"}))
     *     )
     * )
     * @OA\Tag(name="mensaje")
     * @Security(name="Bearer")
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
     *  @OA\Response(
     *     response=200,
     *     description="Devuelve los mensajes enviados a todas las salas por el usuario",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mensaje::class, groups={"mensaje"}))
     *     )
     * )
     * @OA\Tag(name="mensaje")
     * @Security(name="Bearer")
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
     * @OA\Response(
     *     response=200,
     *     description="Devuelve los mensajes recibidos en una sala",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mensaje::class, groups={"mensaje"}))
     *     )
     * )
     * @OA\Tag(name="mensaje")
     * @Security(name="Bearer")
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
     * +++++LISTA LOS MENSAJES DE LA SALA++++++++++++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @OA\Response(
     *     response=200,
     *     description="Devuelve los mensajes de la sala",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mensaje::class, groups={"mensaje"}))
     *     )
     * )
     * @OA\Tag(name="mensaje")
     * @Security(name="Bearer")
     * @Route("/messages_by_sala", name="mensajes_enviados_sala", methods={"POST"} )
     */
    public function mensajesAllSala(Request $req, SerializerInterface $serializer, UsuarioRepository $usuarioRepository, SalaRepository $salaRepository): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        // print_r($data);
        // die;
        $sala = $salaRepository->findOneBy(['id' => $data['sala_id']]);

        $mensajes = $sala->getMensajes();

        $arrayMensajes = json_decode($serializer->serialize($mensajes, 'json', ['groups' => ['mensaje']]), true);

        $mensajesChat = [];
        foreach ($arrayMensajes as $mensaje) {
            array_push($mensajesChat, [
                'fecha' => intval(implode(explode('/', $mensaje['fecha']))),
                'contenido' => $mensaje['contenido'],
                'usuario' => $mensaje['usuario_emisor']['username']
            ]);
            array_push($mensajesChat, [
                'fecha' => intval(implode(explode('/', $mensaje['fecha'])) - 1),
                'contenido' => $mensaje['contenido'],
                'usuario' => $mensaje['usuario_emisor']['username']
            ]);
        }

        asort($mensajesChat);
        $response = new JsonResponse($mensajesChat, Response::HTTP_OK);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++ENVIA UN MENSAJE CON EL USUARIO LOGUEADO++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *  @OA\Response(
     *     response=200,
     *     description="Devuelve el mensaje enviado y guardado en base de datos",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Mensaje::class, groups={"mensaje"}))
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Lanza error si no se ha podido enviar",
     * )
     * @OA\Tag(name="mensaje")
     * @Security(name="Bearer")
     * @Route("/send_message", name="enviar_mensaje", methods={"POST"} )
     */
    public function enviarMensaje(SerializerInterface $serializer): JsonResponse
    {
        $mensajesEnviados = $this->getUser()->getMensajesEnviados();
        return JsonResponse::fromJsonString($serializer->serialize($mensajesEnviados, 'json', ['groups' => ['mensaje']]), Response::HTTP_OK);
    }
}
