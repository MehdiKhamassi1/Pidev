<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\Patient1Type;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/patient')]

class PatientController extends AbstractController
{
    #[Route('/', name: 'app_patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response
    {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher ,SluggerInterface $slugger): Response
    {
        $patient = new Patient();
        $form = $this->createForm(Patient1Type::class, $patient);
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
                        $this->getParameter('user'),
                        $newFilename
                    );
                } catch (FileException $e) {
    
                }
    
                $patient->setprofileImage($newFilename);
                $plaintextPassword = $patientData->getPassword(); 

        $hashedPassword = $passwordHasher->hashPassword($patient, $plaintextPassword);
        $patient->setPassword($hashedPassword);
            }
            $patient->setRoles(['ROLE_PATIENT']);

            $entityManager->persist($patientData);
            $entityManager->flush();

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Patient1Type::class, $patient);
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

    #[Route('/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }
}
