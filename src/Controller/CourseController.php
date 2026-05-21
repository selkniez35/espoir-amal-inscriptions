<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Enum\UserRole;

#[Route('/course')]
final class CourseController extends AbstractController
{
    #[Route('/', name: 'app_course_index', methods: ['GET'])]
    public function index(CourseRepository $courseRepository): Response
    {
        $this->denyAccessUnlessGranted(UserRole::ADMIN->value);

        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_course_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CourseRepository $courseRepository): Response
    {
        $this->denyAccessUnlessGranted(UserRole::ADMIN->value);

        $course = new Course();

        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $courseRepository->save($course);

            $this->addFlash('success', 'Cours créé avec succès.');

            return $this->redirectToRoute('app_course_index');
        }

        return $this->render('course/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_course_show', methods: ['GET'])]
    public function show(Course $course): Response
    {
        $this->denyAccessUnlessGranted(UserRole::ADMIN->value);

        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        $this->denyAccessUnlessGranted(UserRole::ADMIN->value);

        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $courseRepository->save($course);

            $this->addFlash('success', 'Cours modifié avec succès.');

            return $this->redirectToRoute('app_course_index');
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_course_delete', methods: ['POST'])]
    public function delete(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        $this->denyAccessUnlessGranted(UserRole::ADMIN->value);

        if (
            $this->isCsrfTokenValid(
                'delete'.$course->getId(),
                $request->request->get('_token')
            )
        ) {

            $courseRepository->remove($course);

            $this->addFlash('success', 'Cours supprimé.');
        }

        return $this->redirectToRoute('app_course_index');
    }
}