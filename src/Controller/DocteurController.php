<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Form\DocteurType;
use App\Repository\DocteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class DocteurController extends AbstractController
{
    #[Route('/affichagedocteur', name: 'app_docteur_index', methods: ['GET'])]
    public function index(DocteurRepository $docteurRepository): Response
    {
        return $this->render('docteur/index.html.twig', [
            'docteurs' => $docteurRepository->findAll(),
        ]);
    }
    #[Route('/newdocteur', name: 'app_docteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher ,SluggerInterface $slugger): Response
{
    $docteur = new Docteur();
    $form = $this->createForm(DocteurType::class, $docteur);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $docteurData = $form->getData();
        $profileImageFile = $form->get('profileImage')->getData();

        if ($profileImageFile) {
            $originalFilename = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$profileImageFile->guessExtension();

            try {
                $profileImageFile->move(
                    $this->getParameter('docteur'),
                    $newFilename
                );
            } catch (FileException $e) {

            }

            $docteur->setprofileImage($newFilename);
        }
        $entityManager->persist($docteurData);
        $entityManager->flush();

        $user = new User();
        $user->setEmail($docteurData->getEmail());

        $plaintextPassword = $docteurData->getMdp(); 

        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);

        $user->setRoles(['ROLE_DOCTEUR']);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('docteur/new.html.twig', [
        'docteur' => $docteur,
        'form' => $form,
    ]);
}/*
    #[Route('/showdocteur{id}', name: 'app_docteur_show', methods: ['GET'])]
    public function show(Docteur $docteur): Response
    {
        return $this->render('docteur/show.html.twig', [
            'docteur' => $docteur,
        ]);
    }*/
    
#[Route('/showdocteur/{email}', name: 'app_docteur_show', methods: ['GET'])]
public function show(string $email): Response
{
  // Recherche de l'utilisateur par son email
  $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

  if (!$user) {
      throw $this->createNotFoundException('User not found');
  }

  // Récupération du patient associé à cet utilisateur
  //$patient = $user->getPatient();
  $Docteur = $this->getDoctrine()->getRepository(Docteur::class)->findOneBy(['email' => $email]);

  if (!$Docteur) {
      throw $this->createNotFoundException('Docteur not found');
  }

  // Votre logique pour afficher les détails du patient
  return $this->render('docteur/show.html.twig', [
      'docteur' => $Docteur,
  ]);
}
    #[Route('/{id}/editdocteur', name: 'app_docteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Docteur $docteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DocteurType::class, $docteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_docteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('docteur/edit.html.twig', [
            'docteur' => $docteur,
            'form' => $form,
        ]);
    }

    #[Route('/deletedocteur/{id}', name: 'app_docteur_delete', methods: ['POST'])]
    public function delete(Request $request, Docteur $docteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$docteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($docteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_docteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
