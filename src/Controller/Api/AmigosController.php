<?php

namespace App\Controller\Api;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;

/**
 * @Route("/api", name="amigos_api_")
 */
class AmigosController extends AbstractController
{
    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA TODAS LAS PETICIONES RECIBIDAS POR EL USUARIO+++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 
     * @OA\Response(
     *     response=200,
     *     description="Devuelve los amigos que tiene el usuario logeado",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Usuario::class, groups={"amigo"}))
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Lanza error si el usuario no está logueado",
     * )
     * @OA\Tag(name="amigos")
     * @Security(name="Bearer")
     * @Route("/amigos", name="amigos_usuario", methods={"GET"} )
     */
    public function getAmigos(SerializerInterface $serializer): JsonResponse
    {
        try {
            return JsonResponse::fromJsonString($serializer->serialize($this->getUser()->getMisAmigos(), 'json', ['groups' => ['amigo']]), Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "No se han podido recuperar los amigos"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++ELIMINA UN AMIGO SELECCIONADO POR EL USUARIO++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @OA\Response(
     *     response=200,
     *     description="Devuelve un mensaje afirmativo",
     *     @OA\JsonContent(
     *        type="string",
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="Lanza error si el usuario no está logueado",
     * )
     * @OA\Tag(name="amigos")
     * @Security(name="Bearer")
     * @Route("/amigos", name="eliminar_amigo", methods={"POST"} )
     */
    public function eliminarAmigo()
    {
        // Comprueba amistad
        // Si amistad error
        // Comprueba si hay peticion
        // Si peticion activa error
        // Genera peticion
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * +++++++++++++ACEPTA/RECHAZA UNA SOLICITUD RECIBIDA+++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/peticiones", name="rechazar_peticion", methods={"PUT"} )
     */
    public function modificarPeticion()
    {
        // comprueba variable respuesta en peticion
        // si respuesta true genera amistad y peticion inactiva
        // si respuesta false NO genera amistad y peticion inactiva
    }
}
