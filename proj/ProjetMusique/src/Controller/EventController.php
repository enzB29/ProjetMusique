<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Event;
use App\Form\ArtistType;
use App\Form\EventType;
use App\Repository\ArtistRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventController extends AbstractController
{
    #[Route('/event/new', name: 'app_event_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->addParticipant($user);

            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_list'); // Rediriger après l'ajout
        }

        return $this->render('event/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/events', name: 'app_events_list')]
    public function index(EventRepository $eventRepository): Response
    {
        $event = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $event,
        ]);
    }


    #[Route('/event/{id}', name: 'app_event_show')]
    public function show(int $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Artiste non trouvé.');
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'participants' => $event->getParticipants(),
        ]);
    }

}
