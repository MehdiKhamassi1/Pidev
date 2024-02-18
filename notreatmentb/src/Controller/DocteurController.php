<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocteurController extends AbstractController
{
    #[Route('/docteur', name: 'app_docteur')]
    public function index(): Response
    {
        return $this->render('docteur/index.html.twig', [
            'controller_name' => 'DocteurController',
        ]);
    }
}
