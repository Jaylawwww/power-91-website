<?php

namespace App\Controller;

use App\Station\StationCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StationController extends AbstractController
{
    public function __construct(
        private readonly StationCatalog $catalog,
        #[Autowire('%env(RADIO_STREAM_URL)%')]
        private readonly string $streamUrl,
    ) {
    }

    #[Route('/', name: 'home', methods: ['GET'])]
    public function home(): Response
    {
        $now = $this->catalog->now();

        return $this->render('station/home.html.twig', $this->playerContext() + [
            'shows' => $this->catalog->featuredShows(),
            'todaySlots' => $this->catalog->slotsForWeekday((int) $now->format('N')),
            'coastSpots' => $this->catalog->coastSpots(),
            'listenWays' => $this->catalog->listenWays(),
        ]);
    }

    #[Route('/schedule', name: 'schedule', methods: ['GET'])]
    public function schedule(): Response
    {
        $now = $this->catalog->now();

        return $this->render('station/schedule.html.twig', $this->playerContext() + [
            'grid' => $this->catalog->weeklyGrid(),
            'today' => (int) $now->format('N'),
        ]);
    }

    #[Route('/team', name: 'team', methods: ['GET'])]
    public function team(): Response
    {
        return $this->render('station/team.html.twig', $this->playerContext() + [
            'hosts' => $this->catalog->hosts(),
        ]);
    }

    #[Route('/about', name: 'about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('station/about.html.twig', $this->playerContext());
    }

    #[Route('/now-playing', name: 'now_playing', methods: ['GET'])]
    public function nowPlaying(): JsonResponse
    {
        $slot = $this->catalog->onAir();
        $now = $this->catalog->now();

        return $this->json([
            'title' => $slot->title,
            'host' => $slot->host,
            'genre' => $slot->genre,
            'window' => $slot->windowLabel(),
            'clock' => $now->format('g:i:s A T'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function playerContext(): array
    {
        return [
            'onAir' => $this->catalog->onAir(),
            'streamUrl' => $this->streamUrl,
            'stationName' => StationCatalog::NAME,
            'stationTagline' => StationCatalog::TAGLINE,
            'stationCity' => StationCatalog::CITY,
            'studioLine' => StationCatalog::STUDIO_LINE,
            'studioAddress' => StationCatalog::STUDIO_ADDRESS,
            'studioHours' => StationCatalog::STUDIO_HOURS,
            'stationTimezone' => StationCatalog::TIMEZONE,
            'timezoneLabel' => StationCatalog::TIMEZONE_LABEL,
        ];
    }
}
