<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileType;
use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/file")
 */
class FileController extends Controller
{
    /**
     * @Route("/", name="backend_file_index", methods="GET")
     */
    public function index(FileRepository $fileRepository): Response
    {
        return $this->render('backend/file/index.html.twig', ['files' => $fileRepository->findAll()]);
    }

    /**
     * @Route("/new", name="file_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();

            return $this->redirectToRoute('backend_file_index');
        }

        return $this->render('backend/file/new.html.twig', [
            'file' => $file,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="file_show", methods="GET")
     */
    public function show(File $file): Response
    {
        return $this->render('backend/file/show.html.twig', ['file' => $file]);
    }

    /**
     * @Route("/{id}/edit", name="file_edit", methods="GET|POST")
     */
    public function edit(Request $request, File $file): Response
    {
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('file_edit', ['id' => $file->getId()]);
        }

        return $this->render('backend/file/edit.html.twig', [
            'file' => $file,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="file_delete", methods="DELETE")
     */
    public function delete(Request $request, File $file): Response
    {
        if ($this->isCsrfTokenValid('delete'.$file->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();
        }

        return $this->redirectToRoute('backend_file_index');
    }
}
