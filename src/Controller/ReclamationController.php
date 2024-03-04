<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Reponse;
use App\Form\Reponse1Type;
use App\Entity\Reclamation;
use App\Form\Reclamation1Type;
use App\Service\MailerServicerec;
use Doctrine\Common\Util\ClassUtils;
use App\Controller\ReponseController;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReclamationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/iddd', name: 'imagine')]
   public function gotitxd(ReclamationRepository $reclamationRepository)
    { $resultat=$reclamationRepository->findAll();
        $emails = [];
        foreach ($resultat as $entity) {
         $email = $entity->getContenu();
        if ($email !== null) {
        $emails[] = $email;
        }
        }
        $emailString = implode("\n", $emails);
        file_put_contents('demofile.txt', $emailString);
        $justtrg='python C:/xampp/htdocs/Pidevv/public/fir.py';
        $path = exec($justtrg);
    $fileContent = file_get_contents('res.txt');
    $lines = explode("\n", $fileContent);
    $data = array();
    $data[] = array('Degré', 'Nombre de réclamations');
    foreach ($lines as $line) {
        $parts = explode(':', $line);
        if (isset($parts[0]) && isset($parts[1])) {
            $data[] = array((int) $parts[0], (int) $parts[1]);
        }
    }

    return $this->render('reclamation/stats.html.twig', [
        'dat' => json_encode($data),
    ]);
}
    #[Route('/B', name: 'app_reclamation_indexB', methods: ['GET'])]
    public function indexB(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/indexB.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
#[Route('/pdf', name: 'pdf', methods: ['GET'])]
    public function pdf(ReclamationRepository $publicationRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('Reclamation/pdf.html.twig', [
            'reclamations' => $publicationRepository->findAll(),
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="mypdf.pdf"',
            ]
        );
    }

    #[Route('/i/{id}', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository,$id): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findbyid($id),
        ]);
    }

    #[Route('/new/{id}', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,$id,MailerServicerec $mailer): Response
    {   $userid = $request->get('id');
        $user = $entityManager->getRepository(User::class)->find($userid);
        $reclamation = new Reclamation();
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {  
            $reclamation->setUser($user);  
            $entityManager->persist($reclamation);
            $entityManager->flush();
            $message="Vous avez recu une nouvelle reclamation.<br>
            Veuillez verifier la nouvelle liste des reclamations.
            ";

            $mailMessage = $message;
            $mailer->sendEmail(content: $mailMessage);
            return $this->redirectToRoute('app_reclamation_index', ['id' => $reclamation->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation,ReponseRepository $reponseRepository): Response

    {   $reponse=$reponseRepository->findrep($reclamation->getId());
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,'reponse' => $reponse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', ['id' => $reclamation->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamation->setPatient(null);
            $reclamation->setDocteur(null);
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_indexB', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/test', name: 'app_reclamation_inde', methods: ['GET'])]
    public function inde(Request $request): Response
    {
        $patientId = $request->query->get('patientId');
        $reclamations = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findBy(['patient_id' => $patientId]);

        return $this->render('reclamation/test.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }
// back 


#[Route('/idddB', name: 'imagineB')]
   public function gotitxdB(ReclamationRepository $reclamationRepository)
    { $resultat=$reclamationRepository->findAll();
        $emails = [];
        foreach ($resultat as $entity) {
         $email = $entity->getContenu();
        if ($email !== null) {
        $emails[] = $email;
        }
        }
        $emailString = implode("\n", $emails);
        file_put_contents('demofile.txt', $emailString);
        $justtrg='python C:/xampp/htdocs/notreatmentB/public/fir.py';
        $path = exec($justtrg);
    $fileContent = file_get_contents('res.txt');
    $lines = explode("\n", $fileContent);
    $data = array();
    $data[] = array('Degré', 'Nombre de réclamations');
    foreach ($lines as $line) {
        $parts = explode(':', $line);
        if (isset($parts[0]) && isset($parts[1])) {
            $data[] = array((int) $parts[0], (int) $parts[1]);
        }
    }

    return $this->render('reclamation/stats.html.twig', [
        'dat' => json_encode($data),
    ]);
}
#[Route('/pdfB', name: 'pdfB', methods: ['GET'])]
    public function pdfB(ReclamationRepository $publicationRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('Reclamation/pdfB.html.twig', [
            'reclamations' => $publicationRepository->findAll(),
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="mypdf.pdf"',
            ]
        );
    }

    

    #[Route('/B/new', name: 'app_reclamation_newB', methods: ['GET', 'POST'])]
    public function newB(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {        
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_indexB', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/newB.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/B/{id}', name: 'app_reclamation_showB', methods: ['GET'])]
    public function showB(Reclamation $reclamation,ReponseRepository $reponseRepository): Response

    {   $reponse=$reponseRepository->findrep($reclamation->getId());
        return $this->render('reclamation/showB.html.twig', [
            'reclamation' => $reclamation,'reponse' => $reponse,
        ]);
    }

    #[Route('/B/{id}/edit', name: 'app_reclamation_editB', methods: ['GET', 'POST'])]
    public function editB(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_indexB', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/editB.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/B/{id}', name: 'app_reclamation_deleteB', methods: ['POST'])]
    public function deleteB(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamation->setPatient(null);
            $reclamation->setDocteur(null);
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_indexB', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/test', name: 'app_reclamation_indeB', methods: ['GET'])]
    public function indeB(Request $request): Response
    {
        $patientId = $request->query->get('patientId');
        $reclamations = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findBy(['patient_id' => $patientId]);

        return $this->render('reclamation/test.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    
}
