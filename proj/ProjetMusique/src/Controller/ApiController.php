<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/api/artists', name: 'get_artists', methods: ['GET'])]
    public function getArtists(ArtistRepository $artistRepository, SerializerInterface $serializer): JsonResponse
    {
        $artists = $artistRepository->findAll();
        $json = $serializer->serialize($artists, 'json', ['groups' => 'artist:read']);

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/api/events', name: 'get_events', methods: ['GET'])]
    public function getEvents(EventRepository $eventRepository, SerializerInterface $serializer): JsonResponse
    {
        $events = $eventRepository->findAll();
        $json = $serializer->serialize($events, 'json', ['groups' => 'event:read']);

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/api/artists/{id}', name: 'get_artist', methods: ['GET'])]
    public function getArtist(int $id, ArtistRepository $artistRepository): JsonResponse
    {
        $artist = $artistRepository->find($id);

        if (!$artist) {
            throw new NotFoundHttpException('Artist not found');
        }

        return $this->json([
            'id' => $artist->getId(),
            'name' => $artist->getName(),
            'description' => $artist->getDescription(),
            'image' => $artist->getImage(),
        ]);
    }

    #[Route('/api/events/{id}', name: 'get_event', methods: ['GET'])]
    public function getEvent(int $id, EventRepository $eventRepository): JsonResponse
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw new NotFoundHttpException('Event not found');
        }

        return $this->json([
            'id' => $event->getId(),
            'name' => $event->getName(),
            'date' => $event->getDate()->format('Y-m-d H:i:s'),
            'artist' => $event->getArtist()?->getName(),
            'creator' => $event->getCreator()?->getEmail(),
        ]);
    }

}
