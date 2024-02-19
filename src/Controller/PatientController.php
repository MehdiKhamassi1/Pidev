<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\User;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
class PatientController extends AbstractController
{
    #[Route('/affichagepatient', name: 'app_patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response
    {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }
    #[Route('/newpatient', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher , SluggerInterface $slugger
    ): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patientData = $form->getData();
            $profileImageFile = $form->get('profileImage')->getData();

            if ($profileImageFile) {
                $originalFilename = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$profileImageFile->guessExtension();


                try {
                    $profileImageFile->move(
                        $this->getParameter('patient'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }

                $patient->setprofileImage($newFilename);
            }

            $entityManager->persist($patientData);
            $entityManager->flush();

            $user = new User();
            $user->setEmail($patientData->getEmail());

            $plaintextPassword = $patientData->getMdp(); 

            $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($hashedPassword);

            $user->setRoles(['ROLE_PATIENT']);

            

            

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }
/*
    #[Route('/showpatient/{email}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        // Votre logique pour afficher les détails du patient
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }
*/
#[Route('/showpatient/{email}', name: 'app_patient_show', methods: ['GET'])]
public function show(string $email): Response
{
  // Recherche de l'utilisateur par son email
  $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

  if (!$user) {
      throw $this->createNotFoundException('User not found');
  }

  // Récupération du patient associé à cet utilisateur
  //$patient = $user->getPatient();
  $patient = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(['email' => $email]);

  if (!$patient) {
      throw $this->createNotFoundException('Patient not found');
  }

  // Votre logique pour afficher les détails du patient
  return $this->render('patient/show.html.twig', [
      'patient' => $patient,
  ]);
}
    #[Route('/{id}/editpatient', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/deletepatient/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }
}
