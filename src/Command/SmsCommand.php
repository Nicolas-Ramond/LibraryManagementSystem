<?php

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use App\Service\LoggerDependency;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Sms\SmsProvider;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Psr\Log\LogLevel;

/**
 */
class SmsCommand extends Command
{
    private $smsProvider;

    public function __construct(SmsProvider $smsProvider)
    {
        parent::__construct();
        $this->smsProvider = $smsProvider;
    }

    protected function configure()
    {
        $this
            ->setName('app:sms:notifications')
            ->setDescription('SMS command (Format number : +336...)')
            ->addOption('send', 's', InputOption::VALUE_REQUIRED, 'Send SMS to a specific number')
            ->addOption('message', 'm', InputOption::VALUE_REQUIRED, 'Send SMS with a specific message')
//            ->addOption('list', 'l', InputOption::VALUE_NONE, 'List number blacklist')
//            ->addOption('blacklist', 'b', InputOption::VALUE_REQUIRED, 'Remove an number from blacklist')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $verbosityLevelMap = array(
            LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
            LogLevel::INFO   => OutputInterface::VERBOSITY_NORMAL,
        );
        $logger = new ConsoleLogger($output, $verbosityLevelMap);
        // Exécution de la commande avec l’option ‘send’
        // et son paramètre (numéro au format +336)

        if ($input->getOption('send')) {
            $LoggerDependency = new LoggerDependency($logger);
            $LoggerDependency->ready();

            try {
                $LoggerDependency->send();

                //$smsJobs = $ovh->get('/sms/'. $smsServices[0] . '/jobs/'); print_r($smsJobs);

                $message = $input->getOption('message');

                if (!$input->getOption('message')) {
                    echo "Message non spécifié, valeur par défaut";
                    $message = "No text input spécified, just sending some text instead";
                }



                //On sollicite notre service
                $this->smsProvider->sendMessage($input->getOption('send'), $message);


//                $this->getContainer()->get('app.sms.provider')->sendMessage($input->getOption('send'), 'Votre message');
//                $this->log('info', sprintf('SMS send to %s', $input->getOption('send')));
            } catch (\Exception $e) {
//                $this->log('info', sprintf('Error to send an SMS to %s : %s', $input->getOption('blacklist'), $e->getMessage()));
            }
        } else {
            if (!$input->getOption('send')) {
                echo "You're strange, how do you expect me to send some message if you don't specify the phone number? \n";
            }
        }
    }
}
