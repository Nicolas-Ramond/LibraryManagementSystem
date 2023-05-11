<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\PBook;
use App\Form\PBookType;
use App\Repository\PBookRepository;
use App\Workflow\WorkflowProvider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;

/**
 * @Route("/pbook")
 */
class PBookController extends Controller
{
    /**
     * @Route("/", name="backend_pbook_index", methods="GET")
     *
     * @param PBookRepository $pbookRepository
     *
     * @return Response
     */
    public function index(PBookRepository $pbookRepository): Response
    {
        return $this->render('backend/pbook/index.html.twig', ['pbooks' => $pbookRepository->findAll()]);
    }

    /**
     * @Route("/list/{id}", name="backend_pbook_list", methods="GET")
     *
     * @param PBookRepository $pbookRepository
     * @param Book            $book
     *
     * @return Response
     */
    public function list(PBookRepository $pbookRepository, Book $book): Response
    {
        //list all books from Library
        /*
        * @var Library $library
        */
        $library = $this->getUser()->getLibrary();

        foreach ($library->getPBooks() as $pbook) {
            $bookFromLibrary = $pbook->getBook();
            if ($bookFromLibrary == $book)
                $pbooks[] = $pbook;
        }
//        $pbooks = $book->getPBooks();
//dd($pbooks);
        return $this->render('backend/pbook/list.html.twig', ['pbooks' => $pbooks]);
    }

    /**
     * @Route("/new", name="pbook_new", methods="GET|POST")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $pbook = new PBook();
        $form = $this->createForm(PBookType::class, $pbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pbook);
            $em->flush();

            return $this->redirectToRoute('backend_pbook_index');
        }

        return $this->render('backend/pbook/new.html.twig', [
            'pbook' => $pbook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_pbook_show", methods="GET")
     */
    public function show(PBook $pbook): Response
    {
        return $this->render('backend/pbook/show.html.twig', ['pbook' => $pbook]);
    }

    /**
     * @Route("/{id}/edit", name="backend_pbook_edit", methods="GET|POST")
     *
     * @param Request $request
     * @param PBook   $pbook
     *
     * @return Response
     */
    public function edit(Request $request, PBook $pbook): Response
    {
        $form = $this->createForm(PBookEType::class, $pbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_pbook_edit', ['id' => $pbook->getId()]);
        }

        return $this->render('backend/pbook/edit.html.twig', [
            'pbook' => $pbook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_pbook_delete", methods="DELETE")
     */
    public function delete(Request $request, PBook $pbook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pbook->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pbook);
            $em->flush();
        }

        return $this->redirectToRoute('backend_pbook_index');
    }

    /**
     * @Route("/{id}/repaired", name="backend_pbook_repaired", methods="GET|POST")
     * @param Request $request
     * @param PBook $pbook
     * @param Registry $workflows
     * @param WorkflowProvider $workflowProvider
     * @return Response
     */
    public function repaire(Request $request, PBook $pbook, Registry $workflows, WorkflowProvider $workflowProvider): Response
    {

        $workflowProvider->changingState($workflows, $pbook, 'repaired');

        return $this->redirectToRoute('backend_home');
    }

}
