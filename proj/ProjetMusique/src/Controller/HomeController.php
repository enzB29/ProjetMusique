<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->render('home/index.html.twig'); // Create a homepage for guests
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('home/admin.html.twig');
        }

        return $this->render('home/user.html.twig');
    }
}
