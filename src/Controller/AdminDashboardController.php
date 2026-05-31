<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ChildRepository;
use App\Repository\EnrollmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin', name: 'app_admin_dashboard')]
class AdminDashboardController extends AbstractController
{
    #[Route('', name: '')]
    public function index(
        UserRepository $userRepository,
        ChildRepository $childRepository,
        EnrollmentRepository $enrollmentRepository
    ): Response {

        $totalUsers = $userRepository->count([]);
        $totalChildren = $childRepository->count([]);
        $totalEnrollments = $enrollmentRepository->count([]);

        $pendingEnrollments = $enrollmentRepository->count([
            'status' => 'PENDING'
        ]);

        $validatedEnrollments = $enrollmentRepository->count([
            'status' => 'VALIDATED'
        ]);

        return $this->render('admin/dashboard.html.twig', [
            'totalUsers' => $totalUsers,
            'totalChildren' => $totalChildren,
            'totalEnrollments' => $totalEnrollments,
            'pendingEnrollments' => $pendingEnrollments,
            'validatedEnrollments' => $validatedEnrollments,
        ]);
    }
}
