<?php

namespace App\Controller;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/editor")
 */
class EditorController extends Controller
{
    /**
     * @Route("/", name="backend_editor_index", methods="GET")
     */
    public function index(EditorRepository $editorRepository): Response
    {
        return $this->render('backend/editor/index.html.twig', ['editors' => $editorRepository->findAll()]);
    }

    /**
     * @Route("/new", name="editor_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($editor);
            $em->flush();

            return $this->redirectToRoute('backend_editor_index');
        }

        return $this->render('backend/editor/new.html.twig', [
            'editor' => $editor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="editor_show", methods="GET")
     */
    public function show(Editor $editor): Response
    {
        return $this->render('backend/editor/show.html.twig', ['editor' => $editor]);
    }

    /**
     * @Route("/{id}/edit", name="editor_edit", methods="GET|POST")
     */
    public function edit(Request $request, Editor $editor): Response
    {
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('editor_edit', ['id' => $editor->getId()]);
        }

        return $this->render('backend/editor/edit.html.twig', [
            'editor' => $editor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="editor_delete", methods="DELETE")
     */
    public function delete(Request $request, Editor $editor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editor->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($editor);
            $em->flush();
        }

        return $this->redirectToRoute('backend_editor_index');
    }
}
