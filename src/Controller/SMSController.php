<?php

namespace App\Controller;


use App\Service\Sms\SmsProvider;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SMSController extends Controller
{
    public function new(SmsProvider $smsGenerator)
    {
        // thanks to the type-hint, the container will instantiate a
        // new MessageGenerator and pass it to you!
        // ...

        $message = $smsGenerator->getHappyMessage();
        $this->addFlash('success', $message);
        // ...
    }
}
