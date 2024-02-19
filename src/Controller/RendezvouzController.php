<?php

namespace App\Controller;
use App\Entity\Rendezvouz;
use App\Form\Rendezvouz1Type;
use App\Repository\RendezvouzRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rendezvouz')]
class RendezvouzController extends AbstractController
{
    #[Route('/', name: 'app_rendezvouz_index', methods: ['GET'])]
    public function index(RendezvouzRepository $rendezvouzRepository): Response
    {
        return $this->render('rendezvouz/index.html.twig', [
            'rendezvouzs' => $rendezvouzRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rendezvouz_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $rendezvouz = new Rendezvouz();
    // Initialisez le champ local avec une valeur nulle
    $rendezvouz->setLocal(null);

    $form = $this->createForm(Rendezvouz1Type::class, $rendezvouz);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($rendezvouz);
        $entityManager->flush();

        return $this->redirectToRoute('app_rendezvouz_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('rendezvouz/new.html.twig', [
        'rendezvouz' => $rendezvouz,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_rendezvouz_show', methods: ['GET'])]
    public function show(Rendezvouz $rendezvouz): Response
    {
        return $this->render('rendezvouz/show.html.twig', [
            'rendezvouz' => $rendezvouz,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rendezvouz_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rendezvouz $rendezvouz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Rendezvouz1Type::class, $rendezvouz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rendezvouz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvouz/edit.html.twig', [
            'rendezvouz' => $rendezvouz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendezvouz_delete', methods: ['POST'])]
    public function delete(Request $request, Rendezvouz $rendezvouz, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezvouz->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rendezvouz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rendezvouz_index', [], Response::HTTP_SEE_OTHER);
    }
}
