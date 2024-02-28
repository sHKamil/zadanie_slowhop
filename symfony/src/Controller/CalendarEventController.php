<?php

namespace App\Controller;

use App\Service\HttpFile;
use App\Service\IcalParser;
use App\Service\UploaderAWS;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CalendarEventController extends AbstractController
{
    private $httpFile;
    private $parameterBag;
    public $filePath;
    public $fileNamePrefix;

    public function __construct(HttpFile $httpFile, ParameterBagInterface $parameterBag) {
        $this->httpFile = $httpFile;
        $this->parameterBag = $parameterBag;
        $this->fileNamePrefix = time() . bin2hex(random_bytes(4));
        $this->filePath = $this->parameterBag->get('kernel.project_dir') . '/public/calendar/' . $this->fileNamePrefix . '.ics';
    }

    #[Route('/', name: 'app_calendar_event')]
    public function index(): JsonResponse
    {
        $url = 'https://slowhop.com/icalendar-export/api-v1/21c0ed902d012461d28605cdb2a8b7a2.ics';
        $events = $this->getEventsFromUrl($url)['events'];


        return $this->json($events);
    }

    public function getEventsFromUrl(string $url)
    {
        $icalParser = new IcalParser;
        $uploaderAWS = new UploaderAWS;
        $this->httpFile->saveFile($url, $this->filePath);
        $events = $icalParser->getEvents($this->filePath);
        $events = $icalParser->truncateData($events);
        $link = $uploaderAWS->uploadFile(json_encode($events), $this->fileNamePrefix);
        
        return [
            'events' => $events, 
            'link' => $link
        ];
    }
}
