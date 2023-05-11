<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Form\SubscriptionType;
use App\Repository\SubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subscription")
 */
class SubscriptionController extends Controller
{
    /**
     * @Route("/", name="backend_subscription_index", methods="GET")
     */
    public function index(SubscriptionRepository $subscriptionRepository): Response
    {
        return $this->render('backend/subscription/index.html.twig', ['subscriptions' => $subscriptionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="subscription_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $subscription = new Subscription();
        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscription);
            $em->flush();

            return $this->redirectToRoute('backend_subscription_index');
        }

        return $this->render('backend/subscription/new.html.twig', [
            'subscription' => $subscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscription_show", methods="GET")
     */
    public function show(Subscription $subscription): Response
    {
        return $this->render('backend/subscription/show.html.twig', ['subscription' => $subscription]);
    }

    /**
     * @Route("/{id}/edit", name="subscription_edit", methods="GET|POST")
     */
    public function edit(Request $request, Subscription $subscription): Response
    {
        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subscription_edit', ['id' => $subscription->getId()]);
        }

        return $this->render('backend/subscription/edit.html.twig', [
            'subscription' => $subscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscription_delete", methods="DELETE")
     */
    public function delete(Request $request, Subscription $subscription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscription->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subscription);
            $em->flush();
        }

        return $this->redirectToRoute('backend_subscription_index');
    }
}
