<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les erreurs d'authentification
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupérer le dernier nom d'utilisateur saisi (s'il y a lieu)
        $lastUsername = $authenticationUtils->getLastUsername();
    
        // Si l'utilisateur est déjà authentifié, rediriger en fonction de son rôle
        if ($this->getUser()) {
            if ($this->isGranted('ROLE_DOCTEUR')) {
                return $this->redirectToRoute('app_home');
            } elseif ($this->isGranted('ROLE_PATIENT')) {
                return $this->redirectToRoute('app_home');
            }elseif ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_back');
            }
            // Ajouter d'autres conditions de redirection pour d'autres rôles si nécessaire
        }
        
        // Afficher la page de connexion avec les erreurs d'authentification
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout(RequestStack $requestStack, LogoutSuccessHandlerInterface $logoutSuccessHandler): Response
    {
        // Récupérer la requête actuelle
        $request = $requestStack->getCurrentRequest();

        // Symfony appellera le LogoutSuccessHandler pour gérer la redirection après la déconnexion
        return $logoutSuccessHandler->onLogoutSuccess($request);
    }

    #[Route('/loginback', name: 'app_loginback')]
    public function indexback(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les erreurs d'authentification
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupérer le dernier nom d'utilisateur saisi (s'il y a lieu)
        $lastUsername = $authenticationUtils->getLastUsername();
    
        // Si l'utilisateur est déjà authentifié, rediriger en fonction de son rôle
        if ($this->getUser()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_back');
            } 
            // Ajouter d'autres conditions de redirection pour d'autres rôles si nécessaire
        }
        
        // Afficher la page de connexion avec les erreurs d'authentification
        return $this->render('login/index2.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    
}
