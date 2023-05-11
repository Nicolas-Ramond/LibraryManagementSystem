<?php

namespace App\Service;

use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;

class LoggerDependency
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function send()
    {
        $this->logger->info('Im sending the message.');
    }
    public function ready()
    {
        $this->logger->info('Ready to send.');
    }
}
