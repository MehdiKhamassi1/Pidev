<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\Reclamation1Type;
use App\Repository\ReclamationRepository;
use App\Entity\Reponse;
use App\Form\Reponse1Type;
use App\Repository\ReponseRepository;
use App\Controller\ReponseController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Util\ClassUtils;

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
        $justtrg='python C:/xampp/htdocs/notreatment/public/fir.py';
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
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation,ReponseRepository $reponseRepository): Response

    {   $reponse=$reponseRepository->findrep($reclamation->getId());
        var_dump($reponse);
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

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
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
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
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


    
}
