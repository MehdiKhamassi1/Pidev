<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Rendezvouz;
use App\Form\Rendezvouz1Type;
use App\Service\MailerServiceRdv;
use Symfony\Component\Mime\Email;
use App\Repository\LocalRepository;
use App\Repository\RendezvouzRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\Chunk\InformationalChunk;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/rendezvouz')]
class RendezvouzController extends AbstractController
{



/******************calendar*******************/
 
#[Route('/indexmain', name: 'indewmain', methods: ['GET'])]
public function indexmain(RendezvouzRepository $RendezvouzRepository): Response
{
    $events = $RendezvouzRepository->findAll();

    $rdvs = [];

    foreach($events as $event){
        $rdvs[] = [
            'id' => $event->getId(),
            'start' => $event->getDaterdv()->format('Y-m-d H:i:s'),
            'title'=> "rdv ".$event->getId()
            
        ];
    }

    $data = json_encode($rdvs);

    return $this->render('rendezvouz/maincalander.html.twig', ['data'=> $data]);
}


    #[Route('/', name: 'app_rendezvouz_index', methods: ['GET'])]
    public function index(RendezvouzRepository $rendezvouzRepository): Response
    {
        return $this->render('rendezvouz/index.html.twig', [
            'rendezvouzs' => $rendezvouzRepository->findAll(),
        ]);
    }

    #[Route('/local-statistics', name: 'local_statistics')]
    public function statics(RendezvouzRepository $rendezvouzRepository): Response
    {
        $statistics = $rendezvouzRepository->findByRendezvousStatistics();
    
        return $this->render('Local/statrdv.html.twig', [
            'statistics' => $statistics,
        ]);
    }
    


    #[Route('/new/{id}', name: 'app_rendezvouz_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, MailerServiceRdv $mailer,$id): Response
{
    $rendezvouz = new Rendezvouz();
    // Initialisez le champ local avec une valeur nulle
    //$rendezvouz->setLocal(null);
    //$userid = $request->get('id');
    $user = $entityManager->getRepository(User::class)->find($id);
    $form = $this->createForm(Rendezvouz1Type::class, $rendezvouz);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $rendezvouz->setUser($user);  
        $entityManager->persist($rendezvouz);
        $entityManager->flush();
       
        $this->addFlash(
            'info',
            'Rendez-vous généré. Veuillez vérifier votre email.'
        ); 

        $message="
        Nous apprécions votre confiance en nous pour vos besoins de santé et sommes reconnaissants de l'opportunité de vous servir. Si vous avez des questions supplémentaires ou des préoccupations, n'hésitez pas à nous contacter à tout moment.

Nous attendons avec impatience de vous revoir lors de votre prochaine visite. En attendant, nous vous souhaitons une bonne santé et un prompt rétablissement.
<br>votre rendez-vous sa sera en :
 
            ";


            $mailMessage = $message . " " . $rendezvouz->getDaterdv()->format('Y-m-d H:i:s') . "<br> Cordialement.";
            $email=$rendezvouz->getEmail();
            $mailer->sendEmail(content: $mailMessage,to:$email);

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
