<?php

namespace App\Controller;

use App\Entity\SuperAdmin;
use App\Form\SuperAdminType;
use App\Repository\SuperAdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/super_admin")
 */
class SuperAdminController extends Controller
{
    /**
     * @Route("/", name="backend_super_admin_index", methods="GET")
     */
    public function index(SuperAdminRepository $superAdminRepository): Response
    {
        return $this->render('backend/super_admin/index.html.twig', ['superAdmins' => $superAdminRepository->findAll()]);
    }

    /**
     * @Route("/new", name="superAdmin_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $superAdmin = new SuperAdmin();
        $form = $this->createForm(SuperAdminType::class, $superAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($superAdmin);
            $em->flush();

            return $this->redirectToRoute('backend_super_admin_index');
        }

        return $this->render('backend/super_admin/new.html.twig', [
            'superAdmin' => $superAdmin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="superAdmin_show", methods="GET")
     */
    public function show(SuperAdmin $superAdmin): Response
    {
        return $this->render('backend/super_admin/show.html.twig', ['superAdmin' => $superAdmin]);
    }

    /**
     * @Route("/{id}/edit", name="superAdmin_edit", methods="GET|POST")
     */
    public function edit(Request $request, SuperAdmin $superAdmin): Response
    {
        $form = $this->createForm(SuperAdminType::class, $superAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('superAdmin_edit', ['id' => $superAdmin->getId()]);
        }

        return $this->render('backend/super_admin/edit.html.twig', [
            'superAdmin' => $superAdmin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="superAdmin_delete", methods="DELETE")
     */
    public function delete(Request $request, SuperAdmin $superAdmin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$superAdmin->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($superAdmin);
            $em->flush();
        }

        return $this->redirectToRoute('backend_super_admin_index');
    }
}
