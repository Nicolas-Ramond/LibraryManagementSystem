<?php

namespace App\Controller;

use App\Entity\Format;
use App\Form\FormatType;
use App\Repository\FormatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/format")
 */
class FormatController extends Controller
{
    /**
     * @Route("/", name="backend_format_index", methods="GET")
     */
    public function index(FormatRepository $formatRepository): Response
    {
        return $this->render('backend/format/index.html.twig', ['formats' => $formatRepository->findAll()]);
    }

    /**
     * @Route("/new", name="format_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $format = new Format();
        $form = $this->createForm(FormatType::class, $format);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($format);
            $em->flush();

            return $this->redirectToRoute('backend_format_index');
        }

        return $this->render('backend/format/new.html.twig', [
            'format' => $format,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="format_show", methods="GET")
     */
    public function show(Format $format): Response
    {
        return $this->render('backend/format/show.html.twig', ['format' => $format]);
    }

    /**
     * @Route("/{id}/edit", name="format_edit", methods="GET|POST")
     */
    public function edit(Request $request, Format $format): Response
    {
        $form = $this->createForm(FormatType::class, $format);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('format_edit', ['id' => $format->getId()]);
        }

        return $this->render('backend/format/edit.html.twig', [
            'format' => $format,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="format_delete", methods="DELETE")
     */
    public function delete(Request $request, Format $format): Response
    {
        if ($this->isCsrfTokenValid('delete'.$format->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($format);
            $em->flush();
        }

        return $this->redirectToRoute('backend_format_index');
    }
}
