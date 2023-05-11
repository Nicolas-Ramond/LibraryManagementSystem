<?php

namespace App\Controller;

use App\Entity\MemberEBook;
use App\Form\MemberEBookType;
use App\Repository\MemberEBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/member_ebook")
 */
class MemberEBookController extends Controller
{
    /**
     * @Route("/", name="backend_member_ebook_index", methods="GET")
     */
    public function index(MemberEBookRepository $memberEBookRepository): Response
    {
        return $this->render('backend/member_ebook/index.html.twig', ['member_ebooks' => $memberEBookRepository->findAll()]);
    }

    /**
     * @Route("/new", name="member_ebook_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $member_ebook = new MemberEBook();
        $form = $this->createForm(MemberEBookType::class, $member_ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($member_ebook);
            $em->flush();

            return $this->redirectToRoute('backend_member_ebook_index');
        }

        return $this->render('backend/member_ebook/new.html.twig', [
            'member_ebook' => $member_ebook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_ebook_show", methods="GET")
     */
    public function show(MemberEBook $member_ebook): Response
    {
        return $this->render('backend/member_ebook/show.html.twig', ['member_ebook' => $member_ebook]);
    }

    /**
     * @Route("/{id}/edit", name="member_ebook_edit", methods="GET|POST")
     */
    public function edit(Request $request, MemberEBook $member_ebook): Response
    {
        $form = $this->createForm(MemberEBookType::class, $member_ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_ebook_edit', ['id' => $member_ebook->getId()]);
        }

        return $this->render('backend/member_ebook/edit.html.twig', [
            'member_ebook' => $member_ebook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_ebook_delete", methods="DELETE")
     */
    public function delete(Request $request, MemberEBook $member_ebook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member_ebook->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($member_ebook);
            $em->flush();
        }

        return $this->redirectToRoute('backend_member_ebook_index');
    }
}
