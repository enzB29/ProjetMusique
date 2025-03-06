<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArtistController extends AbstractController
{
    #[Route('/artist/new', name: 'app_artist_new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('app_home'); // Rediriger après l'ajout
        }

        return $this->render('artist/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/artists', name: 'app_artist_list')]
    public function index(ArtistRepository $artistRepository): Response
    {
        $artists = $artistRepository->findAll();

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
        ]);
    }

    #[Route('/artist/{id}', name: 'app_artist_show')]
    public function show(int $id, ArtistRepository $artistRepository): Response
    {
        $artist = $artistRepository->find($id);

        if (!$artist) {
            throw $this->createNotFoundException('Artiste non trouvé.');
        }

        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }
}
