<?php

namespace App\Controller\Api;

use App\Controller\Services\FormHandler;
use App\Controller\Services\RegisterHandler;
use App\Entity\Usuario;
use App\Form\Model\UsuarioDto;
use App\Form\Type\AltaFormType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;

/**
 * @Route("/api", name="api_")
 */
class RegisterController extends AbstractController
{
    private $registerHandler;

    public function __construct(RegisterHandler $registerHandler)
    {
        $this->registerHandler = $registerHandler;
    }

    /**
     * @OA\Response(
     *     response=201,
     *     description="Devuelve el usuario creado y envia email a su correo",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Usuario::class, groups={"usuario"}))
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Lanza error si el usuario ya se ha creado o no ha podido loguearse",
     * )
     * @OA\Tag(name="registro")
     * @Route("/alta", name="nuevo_usuario", methods={"POST"} )
     */
    public function altaUsuario(Request $req, UsuarioRepository $usuarioRepository, FormHandler $formHandler, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($req->getContent(), true);

        $username = $data['username'];

        $usuario = $usuarioRepository->findOneBy(["username" => $username]);

        if ($usuario !== null) {
            return new JsonResponse(
                ["error" => "El usuario $username ya está registrado"],
                Response::HTTP_BAD_REQUEST
            );
        }

        $usuarioDto = new UsuarioDto();

        $form = $this->createForm(AltaFormType::class, $usuarioDto);
        $parsedData = $formHandler->parseData($form, $data);
        $form->submit($parsedData);

        if ($form->isSubmitted() && $form->isValid()) {
            $usuario = new Usuario();
            $usuario->setUsername($usuarioDto->username);
            $usuario->setPassword($this->registerHandler->encodePass($usuarioDto->password, $usuario));
            $em->persist($usuario);
            $em->flush();
            $this->registerHandler->sendVerificationEmail($usuarioDto->email, $usuario->getId());
            return JsonResponse::fromJsonString($serializer->serialize($usuario, 'json', ['groups' => ['usuario']]), Response::HTTP_CREATED);
        }


        $errors = $formHandler->getErrorsFromForm($form);
        $response = new JsonResponse(
            [
                "mensaje" => "No se ha podido dar de alta al usuario",
                "errores" => $errors
            ],
            Response::HTTP_BAD_REQUEST
        );

        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @OA\Response(
     *     response=301,
     *     description="Valida la cuenta del usuario y redirige a home",
     * )
     * @OA\Response(
     *     response=400,
     *     description="Lanza error si el usuario no existe",
     * )
     * @OA\Tag(name="registro")
     * @Route("/alta", name="activar_usuario", methods={"GET"})
     */
    public function activarUsuario(Request $req, UsuarioRepository $usuarioRepository, EntityManagerInterface $em): Response
    {

        $usuario = $usuarioRepository->findOneBy(["id" => $req->query->get('usuario')]);

        if ($usuario === null) {
            return new JsonResponse(
                ["error" => "No existe el usuario del cual intentas activar la cuenta"],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $usuario->setIsActive(true);
            $em->persist($usuario);
            $em->flush();
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "No se puede activar la cuenta"],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->redirectToRoute('home', [
            'message' => "Enhorabuena " . $usuario->getUsername() . " tu cuenta ha sido activada"
        ]);
    }
}
