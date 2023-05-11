<?php

namespace App\Controller;

use App\Book\BookCatalogue;
use App\Entity\Book;
use App\Entity\PBook;
use Symfony\Component\Workflow\Registry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends Controller
{
    /**
     * @Route("/", name="backend_book_index", methods="GET")
     *
     * @return Response
     */
    public function index(BookCatalogue $catalogue)
    {
        $library = $this->getUser()->getLibrary();

        $books = [];

        /*
         * @var PBook
         */
        foreach ($library->getPBooks() as $pbook) {
            if (!in_array($pbook->getBook(),$books, TRUE))
            $books[] = $pbook->getBook();
        }


        return $this->render('backend/book/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/{id}/show", name="backend_book_show", methods="GET")
     *
     * @param Book $book
     *
     * @return Response
     */
    public function show(Book $book): Response
    {


        //list all books from Library
        /*
        * @var Library $library
        */
        $library = $this->getUser()->getLibrary();
        foreach ($library->getPBooks() as $pbook) {
            $bookFromLibrary = $pbook->getBook();
            if ($bookFromLibrary == $book)
                $pbooks[] = $book->getPBooks();
        }

        $count = count($pbooks);

        return $this->render('backend/book/show.html.twig', [
            'book' => $book, 'pbooks' => $pbooks, 'count' => $count,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_book_edit", methods="GET")
     *
     * @param Registry $workflows
     */
    public function edit(Registry $workflows)
    {
        $pbook = new PBook();
        $workflow = $workflows->get($pbook);

        // if there are multiple workflows for the same class,
        // pass the workflow name as the second argument
        // $workflow = $workflows->get($pbook, 'blog_publishing');

        // you can also get all workflows associated with an object, which is useful
        // for example to show the status of all those workflows in a backend
        $pbookWorkflows = $workflows->all($pbook);

//        $workflow->can($pbook, 'publish'); // False
//        $workflow->can($pbook, 'to_review'); // True

        // Update the currentState on the post
        try {
            $workflow->apply($pbook, 'to_review');
        } catch (TransitionException $exception) {
            // ... if the transition is not allowed
        }

        // See all the available transitions for the post in the current state
        $transitions = $workflow->getEnabledTransitions($pbook);
    }

    /**
     * @Route("/{id}/delete", name="backend_book_delete", methods="DELETE")
     *
     * @param Request $request
     * @param Book $book
     *
     * @return Response
     */
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();
        }

        return $this->redirectToRoute('backend_book_index');
    }
}
