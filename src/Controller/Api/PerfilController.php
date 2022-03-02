<?php

namespace App\Controller\Api;

use App\Entity\Perfil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;

/**
 * @Route("/api", name="perfil_api_")
 */
class PerfilController extends AbstractController
{
    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++DEVUELVE LOS DATOS DEL PERFIL DEL USUARIO LOGEADO+++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @OA\Response(
     *     response=200,
     *     description="Devuelve los datos del perfil del usuario logeado",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Perfil::class, groups={"perfil"}))
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Lanza error si no se recupera el perfil",
     * )
     * @OA\Tag(name="perfil")
     * @Security(name="Bearer")
     * @Route("/perfil", name="perfil_propio", methods={"GET"} )
     */
    public function getPerfil(SerializerInterface $serializer)
    {
        try {
            return JsonResponse::fromJsonString($serializer->serialize($this->getUser()->getPerfil(), 'json', ['groups' => ['perfil']]), Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "No se ha podido recuperar el perfil"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++DEVUELVE LOS DATOS DEL PERFIL DE UN AMIGO+++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @OA\Response(
     *     response=200,
     *     description="Devuelve los datos del perfil solicitado",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Perfil::class, groups={"perfil"}))
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Lanza error si no se recupera el perfil",
     * )
     * @OA\Tag(name="perfil")
     * @Security(name="Bearer")
     * @Route("/perfil", name="perfil_amigo", methods={"POST"} )
     */
    public function getPerfilAmigo()
    {
        // Comprueba amistad
        // Si amistad error
        // Comprueba si hay peticion
        // Si peticion activa error
        // Genera peticion
    }
}
