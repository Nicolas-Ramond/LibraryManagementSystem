<?php

namespace App\Mailer;

use App\Entity\Booking;
use App\Entity\User;
use Swift_Mailer;
use Swift_Message;
use \Twig\Environment;

class Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var string
     */
    private $mailFrom;

    public function __construct(
        Swift_Mailer $mailer,
        \Twig\Environment $twig,
        string $mailFrom
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
    }

    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render(
            'email/registration.html.twig',
            [
                'user' => $user,
            ]
        );

        $message =
            (new Swift_Message())->setSubject('Welcome to LMS Library Management System')
                ->setFrom($this->mailFrom)
                ->setTo($user->getEmail())
                ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public function sendLateBookingNotification(Booking $booking) {
        $body = $this->twig->render(
            'email/booking/late/notification.html.twig',
            [
                'user' => $booking,
            ]
        );

        $message =
            (new Swift_Message())->setSubject('Welcome to the micro-post app!')
                ->setFrom($this->mailFrom)
                ->setTo($booking->getMember()->getEmail())
                ->setBody($body, 'text/html');

        $this->mailer->send($message);

    }
}