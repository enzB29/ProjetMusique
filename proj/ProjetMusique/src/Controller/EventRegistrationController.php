<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/event')]
class EventRegistrationController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/register/{id}', name: 'app_event_register')]
    public function register(Event $event, EntityManagerInterface $entityManager): RedirectResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $user->registerForEvent($event);
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'You have registered for the event.');

        return $this->redirectToRoute('app_events_list');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/unregister/{id}', name: 'app_event_unregister')]
    public function unregister(Event $event, EntityManagerInterface $entityManager): RedirectResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $user->unregisterFromEvent($event);
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'You have unregistered from the event.');

        return $this->redirectToRoute('app_events_list');
    }
}
