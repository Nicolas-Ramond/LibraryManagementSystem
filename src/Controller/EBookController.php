<?php

namespace App\Controller;

use App\Entity\EBook;
use App\Form\EBookType;
use App\Repository\EBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ebook")
 */
class EBookController extends Controller
{
    /**
     * @Route("/", name="backend_ebook_index", methods="GET")
     */
    public function index(EBookRepository $ebookRepository): Response
    {
        return $this->render('backend/ebook/index.html.twig', ['ebooks' => $ebookRepository->findAll()]);
    }

    /**
     * @Route("/new", name="ebook_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $ebook = new EBook();
        $form = $this->createForm(EBookType::class, $ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ebook);
            $em->flush();

            return $this->redirectToRoute('backend_ebook_index');
        }

        return $this->render('backend/ebook/new.html.twig', [
            'ebook' => $ebook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ebook_show", methods="GET")
     */
    public function show(EBook $ebook): Response
    {
        return $this->render('backend/ebook/show.html.twig', ['ebook' => $ebook]);
    }

    /**
     * @Route("/{id}/edit", name="ebook_edit", methods="GET|POST")
     */
    public function edit(Request $request, EBook $ebook): Response
    {
        $form = $this->createForm(EBookType::class, $ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ebook_edit', ['id' => $ebook->getId()]);
        }

        return $this->render('backend/ebook/edit.html.twig', [
            'ebook' => $ebook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ebook_delete", methods="DELETE")
     */
    public function delete(Request $request, EBook $ebook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ebook->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ebook);
            $em->flush();
        }

        return $this->redirectToRoute('backend_ebook_index');
    }
}
