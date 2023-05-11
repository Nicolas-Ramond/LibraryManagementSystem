<?php

namespace App\Workflow;

use App\Entity\Book;
use App\Entity\Booking;
use App\Entity\PBook;
use Ovh\Exceptions\InvalidParameterException;
use PhpParser\Node\Expr\Cast\Bool_;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Workflow\Registry;

class WorkflowProvider extends AbstractController
{

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param PBook $pbook
     * @param string $transition
     * @param Registry $registry
     */
    public function changingState(Registry $registry, PBook $pbook, string $transition)
    {
        $em = $this->getDoctrine()->getManager();

        $workflow = $registry->get($pbook);

        switch ($transition) {
            case "rent":

                if ($workflow->can($pbook, 'rent')) {
                    $workflow->apply($pbook, 'rent');
                }
                break;
            case "inside_reserv":
                dd($workflow->can($pbook, 'inside_reserv'));
                if ($workflow->can($pbook, 'inside_reserv')) {
                    $workflow->apply($pbook, 'inside_reserv');
                }
                break;
            case "rent_reserv":
                if ($workflow->can($pbook, 'rent_reserv')) {
                    $workflow->apply($pbook, 'rent_reserv');
                }
                break;
            case "return":
                if ($workflow->can($pbook, 'return_reserv')) {
                    $workflow->apply($pbook, 'return_reserv');
                } elseif ($workflow->can($pbook, 'return')) {
                $workflow->apply($pbook, 'return');
                }
                break;
            case "return_reserv":
                if ($workflow->can($pbook, 'return_reserv')) {
                    $workflow->apply($pbook, 'return_reserv');
                }
                break;
            case "return_ko":
                if ($workflow->can($pbook, 'return_ko')) {
                    $workflow->apply($pbook, 'return_ko');
                } elseif ($workflow->can($pbook, 'return_res_ko')) {
                    $workflow->apply($pbook, 'return_res_ko');
                }
                break;
            case "return_res_ko":
                if ($workflow->can($pbook, 'return_res_ko')) {
                    $workflow->apply($pbook, 'return_res_ko');
                }
                break;
            case "ret_no_res_ins":
                if ($workflow->can($pbook, 'ret_no_res_ins')) {
                    $workflow->apply($pbook, 'ret_no_res_ins');
                }
                break;
            case "repaired":
                if ($workflow->can($pbook, 'repaired')) {
                    $workflow->apply($pbook, 'repaired');
                }
                break;
            case "rm_reserv_out":
                if ($workflow->can($pbook, 'rm_reserv_out')) {
                    $workflow->apply($pbook, 'rm_reserv_out');
                }
                break;
            case "rm_reserv_in":
                if ($workflow->can($pbook, 'rm_reserv_in')) {
                    $workflow->apply($pbook, 'rm_reserv_in');
                }
                break;
        }

        $em->persist($pbook);
        $em->flush();

        $this->logger->info('We have contacted the logger: Registering new transition status for Pbook ID: ' . $pbook->getId() . ' with transition: ' . $transition);


    }


}
