<?php

namespace App\Command;

use App\Controller\CalendarEventController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'calendar:event')]
class CalendarEventCommand extends Command
{
    private $calendarEventController;


    public function __construct(CalendarEventController $calendarEventController, string $name = null) {
        $this->calendarEventController = $calendarEventController;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument(name: 'url', mode: InputArgument::OPTIONAL, description: 'File url', default: 'https://slowhop.com/icalendar-export/api-v1/21c0ed902d012461d28605cdb2a8b7a2.ics');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int 
    {
        $url = $input->getArgument(name: 'url');
        $events = json_encode($this->calendarEventController->getEventsFromUrl($url), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        $output->writeln($events);

        return Command::SUCCESS;
    }

}
