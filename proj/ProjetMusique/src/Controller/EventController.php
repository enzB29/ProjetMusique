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
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class EventController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/event/new', name: 'app_event_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $event = new Event();
        $event->setCreator($user);

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

    #[IsGranted('ROLE_USER')]
    #[Route('/events', name: 'app_events_list')]
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        $startDate = $request->query->get('start_date');
        $endDate = $request->query->get('end_date');

        if ($startDate && $endDate) {
            $events = $eventRepository->findByDateRange($startDate, $endDate);
        } else {
            $events = $eventRepository->findAll();
        }

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    #[IsGranted('ROLE_USER')]
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

    #[IsGranted('ROLE_USER')]
    #[Route('/event/{id}/delete', name: 'app_event_delete', methods: ['POST'])]
    public function delete(int $id, EventRepository $eventRepository, EntityManagerInterface $entityManager): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Event non trouvé.');
        }

        if ($event->getCreator() !== $this->getUser() && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw $this->createAccessDeniedException('You cannot delete this event.');
        }

        $entityManager->remove($event);
        $entityManager->flush();

        return $this->redirectToRoute('app_events_list');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/event/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EventRepository $eventRepository, EntityManagerInterface $entityManager): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Event not found.');
        }

        $user = $this->getUser();
        if ($event->getCreator() !== $user && !in_array('ROLE_ADMIN', $user->getRoles())) {
            throw $this->createAccessDeniedException('You cannot edit this event.');
        }

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Event updated successfully.');

            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
        ]);
    }


}
