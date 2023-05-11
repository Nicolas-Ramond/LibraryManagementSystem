<?php

namespace App\Controller;

use App\Entity\Library;
use App\Form\LibraryType;
use App\Repository\LibraryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/library")
 */
class LibraryController extends Controller
{
    /**
     * @Route("/", name="backend_library_index", methods="GET")
     */
    public function index(LibraryRepository $libraryRepository): Response
    {
        return $this->render('backend/library/index.html.twig', ['libraries' => $libraryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="library_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $library = new Library();
        $form = $this->createForm(LibraryType::class, $library);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($library);
            $em->flush();

            return $this->redirectToRoute('backend_library_index');
        }

        return $this->render('backend/library/new.html.twig', [
            'library' => $library,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="library_show", methods="GET")
     */
    public function show(Library $library): Response
    {
        return $this->render('backend/library/show.html.twig', ['library' => $library]);
    }

    /**
     * @Route("/{id}/edit", name="library_edit", methods="GET|POST")
     */
    public function edit(Request $request, Library $library): Response
    {
        $form = $this->createForm(LibraryType::class, $library);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('library_edit', ['id' => $library->getId()]);
        }

        return $this->render('backend/library/edit.html.twig', [
            'library' => $library,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="library_delete", methods="DELETE")
     */
    public function delete(Request $request, Library $library): Response
    {
        if ($this->isCsrfTokenValid('delete'.$library->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($library);
            $em->flush();
        }

        return $this->redirectToRoute('backend_library_index');
    }
}
