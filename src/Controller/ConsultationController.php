<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\Consultation1Type;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\MailerServiceRdv;

#[Route('/consultation')]
class ConsultationController extends AbstractController
{
  

    #[Route('/', name: 'app_consultation_index', methods: ['GET'])]
    public function index(ConsultationRepository $consultationRepository): Response
    {

        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultationRepository->findAll(),
            

        ]);
    }
    
    #[Route('/telecons', name: 'app_consultation_telecons', methods: ['GET'])]
    public function telecons(ConsultationRepository $consultationRepository): Response
    {
        return $this->render('consultation/teleconsultation.html.twig');
    }
       

    #[Route('/new', name: 'app_consultation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MailerServiceRdv $mailer): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(Consultation1Type::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consultation);
            $entityManager->flush();
            $message="This is your teleconsultation link to meet our doctors, our specialists will come to you in few an gide you throughout your demand.
            
            meet.google.com/kkb-vtni-esz";

            $mailMessage=$message;
            $email=$consultation->getEmail();
            $mailer->sendEmail(content: $mailMessage,to:$email);
            return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultation_show', methods: ['GET'])]
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_consultation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Consultation1Type::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultation_delete', methods: ['POST'])]
    public function delete(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
            $consultation->setPatient(null);
            $consultation->setDocteur(null);
            $entityManager->remove($consultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
    }
}
