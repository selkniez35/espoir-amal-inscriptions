<?php

namespace App\Controller;

use App\Enum\UserRole;
use App\Enum\EnrollmentStatus;
use App\Repository\ChildRepository;
use App\Repository\EnrollmentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        EnrollmentRepository $enrollmentRepository,
        UserRepository $userRepository,
        ChildRepository $childRepository
    ): Response {

        if ($this->isGranted(UserRole::ADMIN->value)) {
            return $this->render('home/admin/index.html.twig', [
                'totalChildren' => $childRepository->count([]),
                'totalEnrollments' => $enrollmentRepository->count([]),
                'pendingEnrollments' => $enrollmentRepository->count(['status' => EnrollmentStatus::PENDING->value]),
                'totalUsers' => $userRepository->count([]),
                'latestEnrollments' => $enrollmentRepository->findBy([], ['createAt' => 'DESC'], 5),
            ]);
        }else{
            return $this->render('home/user/index.html.twig');
        }

    }
}
