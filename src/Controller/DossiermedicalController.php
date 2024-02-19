<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DossiermedicalController extends AbstractController
{
    #[Route('/dossiermedical', name: 'app_dossiermedical')]
    public function index(): Response
    {
        return $this->render('dossiermedical/index.html.twig', [
            'controller_name' => 'DossiermedicalController',
        ]);
    }
}
