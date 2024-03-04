<?php

namespace App\Controller;

use App\Entity\Don;
use App\Form\Don1Type;
use App\Repository\DonRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Util\ClassUtils;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\String\Slugger\SluggerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\PdfService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;

#[Route('/don')]
class DonController extends AbstractController
{

    

    
    #[Route('/', name: 'app_don_index', methods: ['GET'])]
    public function index(DonRepository $donRepository): Response
    {
        return $this->render('don/index.html.twig', [
            'dons' => $donRepository->findAll(),
        ]);
    }

    #[Route('/F', name: 'app_don_indexB', methods: ['GET'])]
    public function indexB(DonRepository $donRepository): Response
    {
        return $this->render('don/indexB.html.twig', [
            'dons' => $donRepository->findAll(),
        ]);
    }
    
    

    #[Route('/{id}', name: 'app_don_show', methods: ['GET'])]
    public function show(Don $don): Response
    {
        return $this->render('don/show.html.twig', [
            'don' => $don,
        ]);
    }

    #[Route('/{id}', name: 'app_don_showB', methods: ['GET'])]
    public function showB(Don $don): Response
    {
        return $this->render('don/showB.html.twig', [
            'don' => $don,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_don_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Don $don, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Don1Type::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_don_indexB', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('don/edit.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_don_delete', methods: ['POST'])]
    public function delete(Request $request, Don $don, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$don->getId(), $request->request->get('_token'))) {
    
            $don->setOrganisation(null);
            $entityManager->remove($don);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_don_indexB', [], Response::HTTP_SEE_OTHER);
    }
}
