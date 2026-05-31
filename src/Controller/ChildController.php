<?php

namespace App\Controller;

use App\Entity\Child;
use App\Form\ChildType;
use App\Repository\ChildRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/child')]
final class ChildController extends AbstractController
{
    #[Route('/', name: 'app_child_index', methods: ['GET'])]
    public function index(ChildRepository $childRepository): Response
    {
        return $this->render('child/index.html.twig', [
            'children' => $childRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'app_child_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChildRepository $childRepository): Response
    {
        $child = new Child();

        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $child->setUser($this->getUser());

            $childRepository->save($child);

            $this->addFlash('success', 'Enfant ajouté avec succès.');

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('child/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_child_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Child $child, ChildRepository $childRepository): Response
    {
        if ($child->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $childRepository->save($child);

            $this->addFlash('success', 'Enfant modifié avec succès.');

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('child/edit.html.twig', [
            'form' => $form->createView(),
            'child' => $child,
        ]);
    }
}
