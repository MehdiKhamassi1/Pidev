<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class ApiLoginController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        // Récupérer les données du formulaire de connexion
        $data = json_decode($request->getContent(), true);

        // Vérifier si les données nécessaires sont fournies
        if (!isset($data['username']) || !isset($data['password'])) {
            return $this->json([
                'message' => 'Missing username or password'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Recherche de l'utilisateur en fonction du nom d'utilisateur/email
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'username' => $data['username']
        ]);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $data['password'])) {
            }

        // Générer un token JWT (Vous devez avoir LexikJWTAuthenticationBundle configuré pour cela)
        $token = '...'; // Génération du token JWT à remplacer par la logique réelle

        // Retourner la réponse avec le token
        return $this->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }

}
