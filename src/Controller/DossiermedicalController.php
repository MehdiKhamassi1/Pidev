<?php

namespace App\Controller;

use App\Entity\Dossiermedical;
use App\Form\Dossiermedical2Type;
use App\Repository\DossiermedicalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dossiermedical')]
class DossiermedicalController extends AbstractController
{
    #[Route('/', name: 'app_dossiermedical_index', methods: ['GET'])]
    public function index(DossiermedicalRepository $dossiermedicalRepository): Response
    {
        return $this->render('dossiermedical/index.html.twig', [
            'dossiermedicals' => $dossiermedicalRepository->findAll(),
        ]);
    }
    
  
   
    #[Route('/new', name: 'app_dossiermedical_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dossiermedical = new Dossiermedical();
        $form = $this->createForm(Dossiermedical2Type::class, $dossiermedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dossiermedical);
            $entityManager->flush();

            return $this->redirectToRoute('app_dossiermedical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dossiermedical/new.html.twig', [
            'dossiermedical' => $dossiermedical,
            'form' => $form,
        ]);
    }

 #[Route('/statistics', name: 'dossier_medical_statistics')]
    public function statistics(DossiermedicalRepository $dossiermedicalRepository): Response
    {
        
        $statistics = $dossiermedicalRepository->getChronicDiseaseStatistics();

        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Statistiques des maladies chroniques',
                    'data' => [],
                    'backgroundColor' => ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)'],
                    'borderColor' => ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                    'borderWidth' => 1,
                ],
            ],
        ];

        foreach ($statistics as $label => $count) {
            $chartData['labels'][] = $label;
            $chartData['datasets'][0]['data'][] = $count;
        }

        return $this->render('dossiermedical/statistics.html.twig', [
            'chartData' => json_encode($chartData),
        ]);
    
    }

    #[Route('/dossiermedical/{id}', name: 'app_dossiermedical_show', methods: ['GET'])]
    public function show(Dossiermedical $dossiermedical): Response
    {
        return $this->render('dossiermedical/show.html.twig', [
            'dossiermedical' => $dossiermedical,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dossiermedical_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dossiermedical $dossiermedical, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Dossiermedical2Type::class, $dossiermedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dossiermedical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dossiermedical/edit.html.twig', [
            'dossiermedical' => $dossiermedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dossiermedical_delete', methods: ['POST'])]
    public function delete(Request $request, Dossiermedical $dossiermedical, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dossiermedical->getId(), $request->request->get('_token'))) {
            $dossiermedical->setPatient(null);
            $entityManager->remove($dossiermedical);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dossiermedical_index', [], Response::HTTP_SEE_OTHER);
    }

}
