<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends Command
{
    protected function configure()
    {
        // On set le nom de la commande
        $this->setName('app:cron');

        // On set la description
        $this->setDescription("This command will set cron task in UNIX System");

        // On set l'aide
//        $this->setHelp("Je serai affiche si on lance la commande app/console app:test -h");
        $this->setHelp("This command is for the cron");

        //Aucun argument prévu
//        $this->addArgument('name', InputArgument::REQUIRED, "Quel est ton prenom ?")
//            ->addArgument('last_name', InputArgument::OPTIONAL, "Quel est ton nom ?");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
//        $text = 'Hi '.$input->getArgument('name');
//
//        $lastName = $input->getArgument('last_name');
//        if ($lastName) {
//            $text .= ' '.$lastName;
//        }

        $output->writeln("Your task has been scheduled");
    }
}
