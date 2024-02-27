<?php

namespace App\Service;

use DateTime;
use ICal\ICal;

class IcalParser
{
    public function getEvents(string $filePath) {
        $ical = new ICal($filePath);
        $events = $ical->events();

        return $events;
    }

    public function truncateData(array $events) {
        $truncatedData = [];
        foreach ($events as $i => $event) {
            $truncatedData[$i]['uid'] = $event->uid;
            $truncatedData[$i]['dtstart'] = $this->formatDateTime($event->dtstart);
            $truncatedData[$i]['dtend'] = $this->formatDateTime($event->dtend);
            $truncatedData[$i]['summary'] = $event->summary;
        }

        return $truncatedData;
    }

    private function formatDateTime(string $dateTimeString): string
    {
        $dateTime = DateTime::createFromFormat('Ymd', $dateTimeString);

        return $dateTime->format('Y-m-d');
    }
}
