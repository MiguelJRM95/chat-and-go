<?php

namespace App\Controller\Api;

use App\Controller\Services\FormHandler;
use App\Controller\Services\SalaHandler;
use App\Entity\Sala;
use App\Entity\Usuario;
use App\Repository\SalaRepository;
use App\Repository\UsuarioRepository;
use App\Form\Type\SalaFormType;
use Doctrine\ORM\EntityManagerInterface;
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
    private $salaHandler;

    public function __construct(SalaHandler $salaHandler)
    {
        $this->salaHandler = $salaHandler;
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA TODAS LAS SALAS (solo admin)++++++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/salas", name="salas", methods={"GET"})
     */
    public function salasAll(SalaRepository $salaRepository, SerializerInterface $serializer): JsonResponse
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(
                ["error" => "Solo los administradores pueden ver todas las salas"],
                Response::HTTP_FORBIDDEN
            );
        }

        try {
            $salas = $salaRepository->findAll();
            return JsonResponse::fromJsonString($serializer->serialize($salas, 'json', ['groups' => ['sala']]), Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "El usuario no existe"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA LAS SALAS A LAS CUALES PERTENECE EL USUARIO LOGEADO+++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/salas_usuario", name="salas_usuario", methods={"GET"})
     */
    public function salas(SerializerInterface $serializer): JsonResponse
    {
        try {
            return JsonResponse::fromJsonString($serializer->serialize($this->getUser()->getSalas(), 'json', ['groups' => ['sala']]), Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                ["error" => "El usuario no existe"],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++ELIMINA UNA SALA (solo admin)+++++++++++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/salas_usuario/{sala_id}", name="eliminar_sala", methods={"DELETE"}, requirements={"sala_id"="\d+"} )
     */
    public function removeSala(Request $req, SalaRepository $salaRepository): JsonResponse
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(
                ["error" => "Solo los administradores pueden eliminar las salas"],
                Response::HTTP_FORBIDDEN
            );
        }

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
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++ELIMINA EL USUARIO LOGUEADO DE LA SALA++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/salas_usuario/remove", name="eliminar_from_sala", methods={"PUT"})
     */
    public function removeUsuarioFromSala(Request $req, EntityManagerInterface $em, SerializerInterface $serializer, SalaRepository $salaRepository): JsonResponse
    {
        $data = json_decode($req->getContent(), true);

        $usuario = $this->getUser();
        $salas = $this->getUser()->getSalas();

        $salas = $this->container->get('serializer')->normalize($salas, null, ['groups' => ['sala']]);

        $sala = $this->salaHandler->filterSalasById($salas, $data['sala_id']);

        if ($sala === null) {
            return new JsonResponse(
                ["error" => "La sala no exite."],
                Response::HTTP_BAD_REQUEST
            );
        }

        $sala = $salaRepository->findOneBy(['id' => $data['sala_id']]);

        try {
            $usuario->removeSala($sala);
            $em->persist($usuario);
            $em->flush();
        } catch (\Throwable $th) {
            return new JsonResponse(
                ["error" => "No has podido salir de la sala"],
                Response::HTTP_BAD_REQUEST
            );
        }


        return JsonResponse::fromJsonString($serializer->serialize($this->getUser(), 'json', ['groups' => ['usuario']]), Response::HTTP_OK);
    }


    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++CREA UNA SALA Y AÑADE AL USUARIO QUE LA HA CREADO+++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/salas_usuario/add", name="crear_sala", methods={"POST"} )
     */
    public function createSala(Request $req, SerializerInterface $serializer, EntityManagerInterface $em, FormHandler $formHandler): JsonResponse
    {
        $data = json_decode($req->getContent(), true);

        $usuario = $this->getUser();

        if ($usuario === null) {
            return new JsonResponse(
                ["error" => "El usuario no existe"],
                Response::HTTP_BAD_REQUEST
            );
        }

        $sala = new Sala();

        $form = $this->createForm(SalaFormType::class, $sala);
        $parsedData = $formHandler->parseData($form, $data);
        $form->submit($parsedData);

        if ($form->isSubmitted() && $form->isValid()) {
            $sala->addUsuario($usuario);
            $usuario->addSala($sala);
            $em->persist($sala);
            $em->flush();
            return JsonResponse::fromJsonString($serializer->serialize($sala, 'json', ['groups' => ['sala']]), Response::HTTP_CREATED);
        }

        $errors = $formHandler->getErrorsFromForm($form);

        return new JsonResponse(
            [
                "mensaje" => "No se ha podido crear la sala",
                "errores" => $errors
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++AÑADE UN USUARIO A LA SALA++++++++++++++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
}
