<?php

namespace App\Command;

use App\Controller\CalendarEventController;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'calendar:event')]
class CalendarEventCommand extends Command
{
    private $calendarEventController;
    private $logger;

    public function __construct(CalendarEventController $calendarEventController,LoggerInterface $logger , string $name = null) {
        $this->calendarEventController = $calendarEventController;
        $this->logger = $logger;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument(name: 'url', mode: InputArgument::OPTIONAL, description: 'File url', default: 'https://slowhop.com/icalendar-export/api-v1/21c0ed902d012461d28605cdb2a8b7a2.ics');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int 
    {
        $url = $input->getArgument(name: 'url');
        $response = $this->calendarEventController->getEventsFromUrl($url);
        $events = json_encode($response['events'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->logger->info('New data downloaded from: ' . $url);

        $output->writeln($events);
        if($response['link']) $output->writeln('Link do S3: ' . $response['link']);

        
        return Command::SUCCESS;
    }

}
