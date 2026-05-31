<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\UserRole;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[IsGranted(UserRole::ADMIN->value)]
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/profile', name: 'app_user_profile', methods: ['GET', 'POST'])]
    public function profile(Request $request, UserRepository $userRepository): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user);

            $this->addFlash('success', 'Profil mis à jour avec succès.');

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted(UserRole::ADMIN->value)]
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user);

            $this->addFlash('success', 'Utilisateur créé avec succès.');

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        if (
            !$this->isGranted(UserRole::ADMIN->value)
            && $this->getUser() !== $user
        ) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        UserRepository $userRepository
    ): Response {
        if (
            !$this->isGranted(UserRole::ADMIN->value)
            && $this->getUser() !== $user
        ) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user);

            $this->addFlash('success', 'Profil mis à jour avec succès.');

            if ($this->isGranted(UserRole::ADMIN->value)) {
                return $this->redirectToRoute('app_user_index');
            }

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted(UserRole::ADMIN->value)]
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        User $user,
        UserRepository $userRepository
    ): Response {
        $userRepository->remove($user);

        $this->addFlash('success', 'Utilisateur supprimé.');

        return $this->redirectToRoute('app_user_index');
    }
}
