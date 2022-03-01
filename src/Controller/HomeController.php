<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        return $this->render('home/index.html.twig', [
            'message' => $request->query->get('message'),
        ]);
    }

    /**
     * @Route("/{route}", name="route")
     */
    public function route($route): Response
    {
        //Handle refresh window
        return $this->forward("App\Controller\HomeController::index");
    }
}
