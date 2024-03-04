<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{#[Route('/home', name: 'app_home')]
    public function indexb(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/homeb', name: 'app_homeb')]
    public function index(): Response
    {
        return $this->render('home/indexb.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    
    #[Route('/sign', name: 'app_sign_home')]
    public function sing(): Response
    {
        return $this->render('home/sign.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/about', name: 'app_about_home')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/news', name: 'app_news_home')]
    public function news(): Response
    {
        return $this->render('home/news.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/service', name: 'app_service_home')]
    public function service(): Response
    {
        return $this->render('home/service.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/contact', name: 'app_contact_home')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
