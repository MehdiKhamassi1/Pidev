<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\User;

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
/*
    #[Route('/2fa', name: 'app_2fa')]
    public function twoFactorAuthentication(Request $request, Security $security, MailerInterface $mailer): Response
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $security->getUser();

        // Vérifier si l'utilisateur actuel est authentifié
        if (!$user) {
            throw new AccessDeniedException('Aucun utilisateur actuellement authentifié.');
        }

        // Vérifier si l'utilisateur a activé la double authentification
        if (!$user->isTwoFactorEnabled()) {
            throw new AccessDeniedException('La double authentification n\'est pas activée pour cet utilisateur.');
        }

        // Générer un code aléatoire pour l'authentification à deux facteurs
        $code = mt_rand(100000, 999999);

        // Enregistrer le code dans la session de l'utilisateur
        $request->getSession()->set('two_factor_code', $code);

        // Envoyer le code par e-mail
        $this->sendTwoFactorCodeByEmail($user->getEmail(), $code, $mailer);

        // Afficher le formulaire de saisie du code d'authentification à deux facteurs
        return $this->render('login/two_factor.html.twig', [
            'email' => $user->getEmail(),
        ]);
    }

    private function sendTwoFactorCodeByEmail(string $email, string $code, MailerInterface $mailer): void
    {
        // Créer un objet Email
        $email = (new Email())
            ->from('malekeljendoubi@gmail.com')
            ->to($email)
            ->subject('Code d\'authentification à deux facteurs')
            ->text('Votre code d\'authentification à deux facteurs est : ' . $code);

        // Envoyer l'e-mail
        $mailer->send($email);
    }
   
    */
}
