<?php

namespace App\Book;

use App\Entity\Book;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

class BookWorkflowHandler
{
    private $workflows;
    private $manager;

    public function __construct(Registry $workflows, ObjectManager $manager)
    {
        $this->workflows = $workflows;
        $this->manager = $manager;
    }

    public function handle(Book $book, string $status): void
    {
        # Récupération du Workflow
        $workflow = $this->workflows->get($book);

        # Récupération de Doctrine
        $em = $this->manager;

        # Changement du Workflow
        $workflow->apply($book, $status);

        # Insertion en BDD
        $em->flush();

        # Publication du livre si possible
        if ($workflow->can($book, 'to_be_published')) {
            $workflow->apply($book, 'to_be_published');
            $em->flush();
        }
    }
}
