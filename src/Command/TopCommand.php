<?php

namespace App\Command;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Command\Command;
use App\Service\LoggerDependency;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Book\BookProvider;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;

class TopCommand extends Command
{
    private $bookProvider;
    private $doctrine;

    public function __construct(BookProvider $bookProvider, EntityManagerInterface $doctrine)
    {
        parent::__construct();
        $this->bookProvider = $bookProvider;
        $this->doctrine = $doctrine;
    }

    protected function configure()
    {
        $this
            ->setName('app:top:topbooks')
            ->setDescription('Booking Command : parameter -g for number of top | default at 10')
            ->addOption('numberGiven', 'g', InputOption::VALUE_REQUIRED, 'pass specific number for top');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $verbosityLevelMap = array(
            LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
            LogLevel::INFO => OutputInterface::VERBOSITY_NORMAL,
        );
        $logger = new ConsoleLogger($output, $verbosityLevelMap);

        $LoggerDependency = new LoggerDependency($logger);
        $LoggerDependency->ready();

        try {
//                $LoggerDependency->numberGiven();

            $selectedNumber = $input->getOption('numberGiven');
            if ($input->getOption('numberGiven')) {
                echo 'Number OK! Top ' . $selectedNumber . " selected\n";
            }
            if (!$input->getOption('numberGiven')) {
                echo "Number not specified, default top 10 selected\n";
                $selectedNumber = 10;
            }

            $idBooks = [];

            //Top des livres loués
            $topBooks = $this->bookProvider->topBooks($selectedNumber);


            // by default, this is based on the default style
            $tableStyle = new TableStyle();
            // customizes the style
            $tableStyle
                ->setDefaultCrossingChar('<fg=blue>|</>')
                ->setVerticalBorderChars('<fg=blue>-</>')//                    ->setDefaultCrossingChar(' ')
            ;

            $table = new Table($output);

            $table
                ->setHeaders(array('Nombre de bookings', 'Titre des livres', 'ID des livres'));

            foreach ($topBooks as $bookGroup) {


                    $table
                        ->addRow(
                            [
                                $bookGroup->getCount(), $bookGroup->getBook()['title'], $bookGroup->getBook()['id']
                            ]
                        );
                }


            $table->setStyle($tableStyle);
            $table->render();

            echo "\n";
//                $this->getContainer()->get('app.booking.provider')->sendMessage($input->getOption('send'), 'Votre message');
//                $this->log('info', sprintf('SMS send to %s', $input->getOption('send')));
        } catch (\Exception $e) {
//                $this->log('info', sprintf('Error to send an SMS to %s : %s', $input->getOption('blacklist'), $e->getMessage()));
        }
    }
}
