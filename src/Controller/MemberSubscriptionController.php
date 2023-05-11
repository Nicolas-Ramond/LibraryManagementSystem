<?php

namespace App\Controller;

use App\Entity\MemberSubscription;
use App\Form\MemberSubscriptionType;
use App\Repository\MemberSubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/member_subscription")
 */
class MemberSubscriptionController extends Controller
{
    /**
     * @Route("/", name="backend_member_subscription_index", methods="GET")
     */
    public function index(MemberSubscriptionRepository $memberSubscriptionRepository): Response
    {
        return $this->render('backend/member_subscription/index.html.twig', ['memberSubscriptions' => $memberSubscriptionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="memberSubscription_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $memberSubscription = new MemberSubscription();
        $form = $this->createForm(MemberSubscriptionType::class, $memberSubscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberSubscription);
            $em->flush();

            return $this->redirectToRoute('backend_member_subscription_index');
        }

        return $this->render('backend/member_subscription/new.html.twig', [
            'memberSubscription' => $memberSubscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="memberSubscription_show", methods="GET")
     */
    public function show(MemberSubscription $memberSubscription): Response
    {
        return $this->render('backend/member_subscription/show.html.twig', ['memberSubscription' => $memberSubscription]);
    }

    /**
     * @Route("/{id}/edit", name="memberSubscription_edit", methods="GET|POST")
     */
    public function edit(Request $request, MemberSubscription $memberSubscription): Response
    {
        $form = $this->createForm(MemberSubscriptionType::class, $memberSubscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('memberSubscription_edit', ['id' => $memberSubscription->getId()]);
        }

        return $this->render('backend/member_subscription/edit.html.twig', [
            'memberSubscription' => $memberSubscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="memberSubscription_delete", methods="DELETE")
     */
    public function delete(Request $request, MemberSubscription $memberSubscription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memberSubscription->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($memberSubscription);
            $em->flush();
        }

        return $this->redirectToRoute('backend_member_subscription_index');
    }
}
