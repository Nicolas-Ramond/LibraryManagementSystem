<?php

namespace App\Service\Sms;

use App\Booking\BookingRequest;

/**
 * Created by PhpStorm.
 * User: neo
 * Date: 21/08/18
 * Time: 18:36
 */
class SmsBuilder
{

    /**
     * SmsBuilder constructor.
     * @param $bookingRequest
     * @param SmsProvider $smsProvider
     */
    public function __construct($bookingRequest, SmsProvider $smsProvider)
    {
        $this->bookingRequest = $bookingRequest;
        $this->smsProvider = $smsProvider;
    }

    private $bookingRequest;



    public function smsBuilder(BookingRequest $bookingRequest, string $messageType)
    {
        if ($messageType == 'rent') {
            $message = self::rentMessage($bookingRequest);

        }
        if ($messageType == 'reserve') {
            $message = self::reserveMessage($bookingRequest);

        }
        $phoneMember = $bookingRequest->getMember()->getPhone();
        $this->smsProvider->sendMessage($phoneMember, $message);

    }

    private static function rentMessage(BookingRequest $bookingRequest): string
    {
        //Composition du message pour envoi sms
        $firstnameMember = $bookingRequest->getMember()->getFirstName();
        $bookTitle = $bookingRequest->getPBook()->getBook()->getTitle();
        $endDate = $bookingRequest->getEndDate()->format('d M Y');
        $message = 'Bonjour ' . $firstnameMember . ', vous venez d\'emprunter "' . $bookTitle . '". Son retour est programmé pour le ' . $endDate . '. Bonne lecture !';
        return $message;
    }


    private static function reserveMessage(BookingRequest $bookingRequest)
    {
        //Composition du message pour envoi sms
        $firstnameMember = $bookingRequest->getMember()->getFirstName();
        $bookTitle = $bookingRequest->getPBook()->getBook()->getTitle();
        $endDate = $bookingRequest->getEndDate()->format('d M Y');
        $message = 'Bonjour ' . $firstnameMember . ', vous venez de réserver "' . $bookTitle . '". Vous avez un jour pour le récupérer à l\'accueil';
        return $message;
    }

}