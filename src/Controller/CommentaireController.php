<?php

namespace App\Controller;
use App\Entity\Publication;
use App\Entity\Commentaire;
use App\Form\Commentaire1Type;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commentaire')]
class CommentaireController extends AbstractController
{
    #[Route('/B', name: 'app_commentaire_indexB', methods: ['GET'])]
    public function indexB(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/indexB.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    #[Route('/B/commentaires-tri-signalements', name: 'commentaires_tri_signalements')]
    public function commentairesTriSignalements(CommentaireRepository $commentaireRepository): Response
    {
        $commentaires = $commentaireRepository->findByNombreSignalementsCroissant();
        return $this->render('commentaire/indexB.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/signalement/{id}', name: 'commentaire_signalement')]
    public function signalerCommentaire(Commentaire $commentaire, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire->incrementSignalements();
        $entityManager->flush();

        if ($commentaire->getSignalements() >= 5) {
            $entityManager->remove($commentaire);
            $entityManager->flush();

            $this->addFlash('success', 'Le commentaire a été supprimé en raison de signalements répétés.');
        } else {
            $this->addFlash('success', 'Le commentaire a été signalé avec succès.');
        }

        return $this->redirectToRoute('app_publication_index');
    }
    


    #[Route('/', name: 'app_commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {   $publicationId = $request->get('id');
        $publication = $entityManager->getRepository(Publication::class)->find($publicationId);
        $commentaire = new Commentaire();
        $commentaire->setPublication($publication);
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_indexB', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/B/commentaires-tri-signalements', name: 'commentaires_tri_signalementsB')]
    public function commentairesTriSignalementsB(CommentaireRepository $commentaireRepository): Response
    {
        $commentaires = $commentaireRepository->findByNombreSignalementsCroissant();
        return $this->render('commentaire/indexB.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/B/signalement/{id}', name: 'commentaire_signalementB')]
    public function signalerCommentaireB(Commentaire $commentaire, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire->incrementSignalements();
        $entityManager->flush();

        if ($commentaire->getSignalements() >= 5) {
            $entityManager->remove($commentaire);
            $entityManager->flush();

            $this->addFlash('success', 'Le commentaire a été supprimé en raison de signalements répétés.');
        } else {
            $this->addFlash('success', 'Le commentaire a été signalé avec succès.');
        }

        return $this->redirectToRoute('app_commentaire_indexB');
    }
    

    #[Route('/B/new', name: 'app_commentaire_newB', methods: ['GET', 'POST'])]
    public function newB(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_indexB', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/newB.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/B/{id}', name: 'app_commentaire_showB', methods: ['GET'])]
    public function showB(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/showB.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/B/{id}/edit', name: 'app_commentaire_editB', methods: ['GET', 'POST'])]
    public function editB(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_indexB', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/editB.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/B/{id}', name: 'app_commentaire_deleteB', methods: ['POST'])]
    public function deleteB(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_indexB', [], Response::HTTP_SEE_OTHER);
    }
}
