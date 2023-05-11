<?php

namespace App\Service\Member;

use App\Entity\Booking;
use App\Entity\Member;
use Ovh\Exceptions\InvalidParameterException;
use PhpParser\Node\Expr\Cast\Bool_;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemberProvider extends AbstractController
{
//    /*
//     * @var EntityManagerInterface $em
//     */
//    private $em;


    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Member $member
     * @return bool
     */
    public function verifyIfBookingCanBeValid(Member $member): Bool
    {
        try {
            $em = $this->getDoctrine()->getManager();

            $numberOfBooking = $em->getRepository(Booking::class)
                ->findValueOfBookingForOneMember($member);



            //Ici on log le message envoyé ainsi que le numéro pour le suivi
            $this->logger->info('We have contacted the logger: ' . $member . ' would like to make a new reservation ');

            if ($numberOfBooking < 3) {
                return true;
            }
            if ($numberOfBooking = 3) {
                return false;
            }
        } catch (\Exception $e) {
            echo "erreur";
            if (null !== $this->logger) {
                $this->logger->critical(
                    sprintf("erreur critique")
                );
            }

            $result = false;
        }

        return $result;
    }
}
