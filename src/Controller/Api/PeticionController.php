<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="peticion_api_")
 */
class PeticionController extends AbstractController
{
    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++LISTA TODAS LAS PETICIONES RECIBIDAS POR EL USUARIO+++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/peticiones", name="peticiones_usuario", methods={"GET"} )
     */
    public function getPeticionesRecibidas()
    {
    }

    /** 
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * ++++++ENVIA UNA PETICION AL USUARIO DESTINO+++++++++++++++++++++++++++
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * @Route("/peticiones", name="enviar_peticion", methods={"POST"} )
     */
    public function enviarPeticion()
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
