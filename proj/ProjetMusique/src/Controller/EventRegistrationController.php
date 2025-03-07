<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventRegistrationController extends AbstractController
{
    #[Route('/event/registration', name: 'app_event_registration')]
    public function index(): Response
    {
        return $this->render('event_registration/index.html.twig', [
            'controller_name' => 'EventRegistrationController',
        ]);
    }
}
