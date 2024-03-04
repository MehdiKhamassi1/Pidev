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
    
    #[Route('/new', name: 'app_don_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MailerService $mailer,SluggerInterface $slugger): Response
    {
        
        $don = new Don();
        $form = $this->createForm(Don1Type::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($don->getMontant()!==0 && $don->getMontant()!==null){

                $pdfContent = "
                <style>

                .header {
                background-color: #5AAC4E;
                color: white;
                padding: 20px; /* Increased padding */
                text-align: center;
                position: fixed;
                width: 100%; /* Largeur de la bande sur toute la page */
                top: 0;
                z-index: 1000; /* Assure que la bande est au-dessus de l'image */
                font-size: 24px; /* Increased font size */
            }
            
            
                    /* Style de la pagination */
                    .footer {
                        background-color: #5AAC4E;
                        color: white;
                        padding: 10px;
                        text-align: center;
                        position: fixed;
                        width: 100%;
                        bottom: 0;
                    }
            
                    /* Style de la pagination */
                    .page-number::after {
                        content: counter(page);
                    }
            
                    /* Définition de la numérotation des pages */
                    @page {
                        @bottom-center {
                            content: counter(page);
                        }
                    }
                </style>
            
                <!-- Bande en haut -->
                <div class='header'>
                    NoTreatment donation service
                </div>
            
                <!-- Contenu principal -->
                <div style='margin-top: 50px;'>
                    <table style='margin: auto; border-collapse: collapse; width: 80%;'>
                    <br><br>
                        <tr>
                            <td colspan='2' style='text-align: center; padding-bottom: 20px;'>
                                <h1 style='font-weight: bold;'>Reçu donation {$don->getId()}</h1>
                            </td>
                        </tr><br><br>
                        <tr>
                            <td style='padding-right: 20px;'><strong>Nom:</strong></td>
                            <td>{$don->getNom()}</td>
                        </tr><br>
                        <tr>
                            <td style='padding-right: 20px;'><strong>Prénom:</strong></td>
                            <td>{$don->getPrenom()}</td>
                        </tr><br>
                        <tr>
                            <td style='padding-right: 20px;'><strong>Type:</strong></td>
                            <td>{$don->getType()}</td>
                        </tr><br>
                        <tr>
                            <td style='padding-right: 20px;'><strong>Description:</strong></td>
                            <td>{$don->getDescription()}</td>
                        </tr><br>
                        <tr>
                            <td style='padding-right: 20px;'><strong>Organisation:</strong></td>
                            <td>{$don->getOrganisation()}</td>
                        </tr><br>
                        <tr>
                            <td style='padding-right: 20px;'><strong>Montant:</strong></td>
                            <td>{$don->getMontant()} TND</td>
                        </tr><br>
                        
                    </table>
                </div>
                <!-- Bande en bas -->
                <div class='footer'>
                    <span class='page-number'></span>
                </div>
";
    }
            else
            {
                $pdfContent = "
                
    <style>

    .header {
    background-color: #5AAC4E;
    color: white;
    padding: 20px; /* Increased padding */
    text-align: center;
    position: fixed;
    width: 100%; /* Largeur de la bande sur toute la page */
    top: 0;
    z-index: 1000; /* Assure que la bande est au-dessus de l'image */
    font-size: 24px; /* Increased font size */
}


        /* Style de la pagination */
        .footer {
            background-color: #5AAC4E;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Style de la pagination */
        .page-number::after {
            content: counter(page);
        }

        /* Définition de la numérotation des pages */
        @page {
            @bottom-center {
                content: counter(page);
            }
        }
    </style>

    <!-- Bande en haut -->
    <div class='header'>
        NoTreatment donation service
    </div>

    <!-- Contenu principal -->
    <div style='margin-top: 50px;'>
        <table style='margin: auto; border-collapse: collapse; width: 80%;'>
        <br><br>
            <tr>
                <td colspan='2' style='text-align: center; padding-bottom: 20px;'>
                    <h1 style='font-weight: bold;'>Reçu donation N°{$don->getId()}</h1>
                </td>
            </tr><br><br>
            <tr>
                <td style='padding-right: 20px;'><strong>Nom:</strong></td>
                <td>{$don->getNom()}</td>
            </tr><br>
            <tr>
                <td style='padding-right: 20px;'><strong>Prénom:</strong></td>
                <td>{$don->getPrenom()}</td>
            </tr><br>
            <tr>
                <td style='padding-right: 20px;'><strong>Type:</strong></td>
                <td>{$don->getType()}</td>
            </tr><br>
            <tr>
                <td style='padding-right: 20px;'><strong>Description:</strong></td>
                <td>{$don->getDescription()}</td>
            </tr><br>
            <tr>
                <td style='padding-right: 20px;'><strong>Organisation:</strong></td>
                <td>{$don->getOrganisation()}</td>
            </tr><br>
            <tr>
                <td style='padding-right: 20px;'><strong>Equipement:</strong></td>
                <td>{$don->getImage()}</td>
            </tr><br>
            
        </table>
    </div>
    <!-- Bande en bas -->
    <div class='footer'>
        <span class='page-number'></span>
    </div>
" 
;


}



        // Create PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdfContent);

        // (Optional) Set options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        // Render PDF (Optional)
        $dompdf->render();

        // Save PDF file temporarily (or you can store it in a directory)
        $pdfDirectory = '/public/uploads/pdf/';

// Create the directory if it doesn't exist
if (!file_exists($pdfDirectory)) {
    mkdir($pdfDirectory, 0777, true);
}

// Define the full file path including the directory
$pdfFilePath = $pdfDirectory . 'Recu.pdf';
        file_put_contents($pdfFilePath, $dompdf->output());




            $image = $form->get('photo')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                
                try {
                    $image->move(
                        $this->getParameter('don_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                   
                }

                $don->setImage($newFilename);
            }
            $entityManager->persist($don);
            $entityManager->flush();
            

            $message="
            Au nom de NoTreatment, nous tenons à exprimer notre profonde gratitude pour votre généreuse donation. <br><br>
            Votre contribution aura un impact significatif sur notre mission visant à aider les gens en besoin. <br><br>
            Nous vous remercions une fois de plus pour votre gentillesse et votre soutien. <br><br>
            
            Cordialement,<br>
            L'équipe NoTreatment,<br> 
            ";

            $mailMessage='Cher '.$don->getnom().' '.$don->getPrenom().' '.$message;
            $email=$don->getEmail();
            $mailer->sendEmail(content: $mailMessage,to:$email, pdf: $pdfFilePath);
           
            if ($don->getMontant() !== null && $don->getMontant() != 0) {
                //return $this->redirectToRoute('checkout', [], Response::HTTP_SEE_OTHER);
                return $this->redirectToRoute('checkout', ['data' => $don->getMontant(),'data1' =>$don->getDescription()],Response::HTTP_SEE_OTHER);
            }
            else 
            return $this->redirectToRoute('app_don_index', [], Response::HTTP_SEE_OTHER);
        
        }

        return $this->renderForm('don/new.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }


    #[Route('/pdf/{id}', name: 'don.pdf')]
    public function generatePdfDon(Don $don = null, PdfService $pdf) {
        $html = $this->render('don/fichier.html.twig', ['don' => $don]);
        $pdf->showPdfFile($html);
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
