<?php

namespace App\Controller;

use App\Entity\Local;
use App\Entity\Rendezvouz;
use App\Form\Local1Type;
use App\Repository\LocalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/local')]
class LocalController extends AbstractController
{
    #[Route('/', name: 'app_local_index', methods: ['GET'])]
    public function index(LocalRepository $localRepository): Response
    {
        return $this->render('local/index.html.twig', [
            'locals' => $localRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_local_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager , SluggerInterface $slugger): Response
    {
        $local = new Local();
        $form = $this->createForm(Local1Type::class, $local);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('local_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'photoname' property to store the PDF file name
                // instead of its contents
                $local->setImage($newFilename);
            }
            $entityManager->persist($local);
            $entityManager->flush();

            return $this->redirectToRoute('app_local_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('local/new.html.twig', [
            'local' => $local,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_local_show', methods: ['GET'])]
    public function show(Local $local): Response
    {
        return $this->render('local/show.html.twig', [
            'local' => $local,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_local_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Local $local, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Local1Type::class, $local);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_local_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('local/edit.html.twig', [
            'local' => $local,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_local_delete', methods: ['POST'])]
    public function delete(Request $request, Local $local, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$local->getId(), $request->request->get('_token'))) {
            $entityManager->remove($local);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_local_index', [], Response::HTTP_SEE_OTHER);
    }

   


}
