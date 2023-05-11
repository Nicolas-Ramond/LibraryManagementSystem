<?php
/**
 * Created by PhpStorm.
 * User: moulaye
 * Date: 24/07/18
 * Time: 11:22.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserLoginType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class UserController.
 *
 *
 * @Route("/" )
 * Route("/user" )
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="backend_user_index", methods="GET")
     *
     * @param UserRepository $userRepository
     *
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('backend/user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

//    /**
//     * @Route("/new", name="user_new", methods="GET|POST")
//     * @param Request $request
//     *
//     * @return Response
//     */
//    public function new(Request $request): Response
//    {
//        $user = new User();
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($user);
//            $em->flush();
//
//            return $this->redirectToRoute('backend_user_index');
//        }
//
//        return $this->render('backend/user/new.html.twig', [
//            'user' => $user,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="user_show", methods="GET")
//     * @param User $user
//     *
//     * @return Response
//     */
//    public function show(User $user): Response
//    {
//        return $this->render('backend/user/show.html.twig', ['user' => $user]);
//    }
//
//    /**
//     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
//     * @param Request $request
//     * @param User    $user
//     *
//     * @return Response
//     */
//    public function edit(Request $request, User $user): Response
//    {
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
//        }
//
//        return $this->render('backend/user/edit.html.twig', [
//            'user' => $user,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="user_delete", methods="DELETE")
//     * @param Request $request
//     * @param User    $user
//     *
//     * @return Response
//     */
//    public function delete(Request $request, User $user): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($user);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('backend_user_index');
//    }

    /**
     * connection.
     *
     * Route(
     *     {
     *          "fr": "/connexion",
     *          "en": "/login"
     *      },
     *     name="backend_user_login"
     * )
     *
     * @Route( path="/login", name="backend_user_login" )
     *
     * @param Request             $request
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        /*
         * If user is login and is granted permissions go to home page
         *
         */
//        if ($this->getUser()) {
//            return $this->redirectToRoute('backend_home');
//        }

        /**
         * Retrieve user login form.
         */
        $form = $this->createForm(UserLoginType::class, ['email' => $authenticationUtils->getLastUsername()]);

        /**
         * Get error message.
         */
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render(
            'backend/user/login.html.twig',
            [
                'form' => $form->createView(),
                'error' => $error,
            ]
        );
    }
}
