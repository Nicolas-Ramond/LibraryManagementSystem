<?php

// /src/AppBundle/Event/Subscriber/CustomAuditTrailListener.php

namespace App\Event\Subscriber;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class CustomAuditTrailListener implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public function onLeave(Event $event)
    {
        $this->logger->debug('on leave', [
            'marking - places' => $event->getMarking()->getPlaces(),
            'transition' => $event->getTransition()->getName(),
        ]);
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.pbook_status.leave' => 'onLeave',
        ];
    }
}
