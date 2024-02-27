<?php

namespace App\Controller;

use App\Service\HttpFile;
use App\Service\IcalParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CalendarEventController extends AbstractController
{
    private $httpFile;

    public function __construct(HttpFile $httpFile) {
        $this->httpFile = $httpFile;
    }

    #[Route('/', name: 'app_calendar_event')]
    public function index(): JsonResponse
    {
        $icalParser = new IcalParser;
        $url = 'https://slowhop.com/icalendar-export/api-v1/21c0ed902d012461d28605cdb2a8b7a2.ics';
        $this->httpFile->saveFile($url);
        $events = $icalParser->getEvents();
        $events = $icalParser->truncateData($events);

        return $this->json($events);
    }
}
