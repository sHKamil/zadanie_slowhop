<?php

namespace App\Controller;

use App\Service\HttpFile;
use App\Service\IcalParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CalendarEventController extends AbstractController
{
    private $httpFile;
    private $parameterBag;
    public $filePath;

    public function __construct(HttpFile $httpFile, ParameterBagInterface $parameterBag, $fileName = 'file.ics') {
        $this->httpFile = $httpFile;
        $this->parameterBag = $parameterBag;
        $this->filePath = $this->parameterBag->get('kernel.project_dir') . '/public/' . $fileName;
    }

    #[Route('/', name: 'app_calendar_event')]
    public function index(): JsonResponse
    {
        $url = 'https://slowhop.com/icalendar-export/api-v1/21c0ed902d012461d28605cdb2a8b7a2.ics';
        $events = $this->getEventsFromUrl($url);

        return $this->json($events);
    }

    public function getEventsFromUrl(string $url)
    {
        $icalParser = new IcalParser;
        $this->httpFile->saveFile($url, $this->filePath);
        $events = $icalParser->getEvents($this->filePath);
        $events = $icalParser->truncateData($events);

        return $events;
    }
}
