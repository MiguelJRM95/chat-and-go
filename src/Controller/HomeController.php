<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        if ($request->query->get('message')) {
            $response = new Response();
            $expires = time() + 36000;
            $cookie = Cookie::create('verificado', $request->query->get('message'),  $expires, '/', null, false, false);

            $response->headers->setCookie($cookie);

            $content = $this->renderView('home/index.html.twig');
            $response->setContent($content);
            $response->headers->set('Content-Type', 'text/html');
            return $response;
        }

        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/{route}", name="route")
     */
    public function route(Request $request): Response
    {
        return $this->forward("App\Controller\HomeController::index");
    }
}
