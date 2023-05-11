<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sub_category")
 */
class SubCategoryController extends Controller
{
    /**
     * @Route("/", name="backend_sub_category_index", methods="GET")
     */
    public function index(SubCategoryRepository $subCategoryRepository): Response
    {
        return $this->render('backend/sub_sub_category/index.html.twig', ['categories' => $subCategoryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="backend_sub_category_new", methods="GET|POST")
     */
    public function save(Request $request): Response
    {
        $subCategory = new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subCategory);
            $em->flush();

            return $this->redirectToRoute('backend_sub_category_index');
        }

        return $this->render('backend/sub_category/new.html.twig', [
            'category' => $subCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_sub_category_show", methods="GET")
     */
    public function show(SubCategory $subCategory): Response
    {
        return $this->render('backend/sub_category/show.html.twig', ['category' => $subCategory]);
    }

    /**
     * @Route("/{id}/edit", name="backend_sub_category_edit", methods="GET|POST")
     */
    public function edit(Request $request, SubCategory $subCategory): Response
    {
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_edit', ['id' => $subCategory->getId()]);
        }

        return $this->render('backend/sub_category/edit.html.twig', [
            'category' => $subCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_sub_category_delete", methods="DELETE")
     */
    public function delete(Request $request, SubCategory $subCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subCategory->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subCategory);
            $em->flush();
        }

        return $this->redirectToRoute('backend_sub_category_index');
    }
}
