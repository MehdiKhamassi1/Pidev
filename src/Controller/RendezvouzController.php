<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RendezvouzController extends AbstractController
{
    #[Route('/rendezvouz', name: 'app_rendezvouz')]
    public function index(): Response
    {
        return $this->render('rendezvouz/index.html.twig', [
            'controller_name' => 'RendezvouzController',
        ]);
    }
}
