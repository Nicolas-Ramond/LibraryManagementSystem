<?php

namespace App\Controller;

use App\Entity\MemberType;
use App\Form\MemberTypeType;
use App\Repository\MemberTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/member_type")
 */
class MemberTypeController extends Controller
{
    /**
     * @Route("/", name="backend_member_type_index", methods="GET")
     */
    public function index(MemberTypeRepository $memberTypeRepository): Response
    {
        return $this->render('backend/member_type/index.html.twig', ['member_types' => $memberTypeRepository->findAll()]);
    }

    /**
     * @Route("/new", name="member_type_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $memberType = new MemberType();
        $form = $this->createForm(MemberTypeType::class, $memberType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberType);
            $em->flush();

            return $this->redirectToRoute('backend_member_type_index');
        }

        return $this->render('backend/member_type/new.html.twig', [
            'member_type' => $memberType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_type_show", methods="GET")
     */
    public function show(MemberType $memberType): Response
    {
        return $this->render('backend/member_type/show.html.twig', ['member_type' => $memberType]);
    }

    /**
     * @Route("/{id}/edit", name="member_type_edit", methods="GET|POST")
     */
    public function edit(Request $request, MemberType $memberType): Response
    {
        $form = $this->createForm(MemberTypeType::class, $memberType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_type_edit', ['id' => $memberType->getId()]);
        }

        return $this->render('backend/member_type/edit.html.twig', [
            'member_type' => $memberType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_type_delete", methods="DELETE")
     */
    public function delete(Request $request, MemberType $memberType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memberType->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($memberType);
            $em->flush();
        }

        return $this->redirectToRoute('backend_member_type_index');
    }
}
