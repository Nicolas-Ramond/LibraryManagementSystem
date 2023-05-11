<?php

namespace App\Controller;

use App\Entity\Librarian;
use App\Form\LibrarianType;
use App\Repository\LibrarianRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/librarian")
 */
class LibrarianController extends Controller
{
    /**
     * @Route("/", name="backend_librarian_index", methods="GET")
     *
     * @param LibrarianRepository $librarianRepository
     *
     * @return Response
     */
    public function index(LibrarianRepository $librarianRepository): Response
    {
        return $this->render('backend/librarian/index.html.twig', ['librarians' => $librarianRepository->findAll()]);
    }

    /**
     * @Route("/new", name="librarian_new", methods="GET|POST")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $librarian = new Librarian();
        $form = $this->createForm(LibrarianType::class, $librarian);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($librarian);
            $em->flush();

            return $this->redirectToRoute('backend_librarian_index');
        }

        return $this->render('backend/librarian/new.html.twig', [
            'librarian' => $librarian,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="librarian_show", methods="GET")
     */
    public function show(Librarian $librarian): Response
    {
        return $this->render('backend/librarian/show.html.twig', ['librarian' => $librarian]);
    }

    /**
     * @Route("/{id}/edit", name="librarian_edit", methods="GET|POST")
     */
    public function edit(Request $request, Librarian $librarian): Response
    {
        $form = $this->createForm(LibrarianType::class, $librarian);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('librarian_edit', ['id' => $librarian->getId()]);
        }

        return $this->render('backend/librarian/edit.html.twig', [
            'librarian' => $librarian,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="librarian_delete", methods="DELETE")
     */
    public function delete(Request $request, Librarian $librarian): Response
    {
        if ($this->isCsrfTokenValid('delete'.$librarian->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($librarian);
            $em->flush();
        }

        return $this->redirectToRoute('backend_librarian_index');
    }
}
