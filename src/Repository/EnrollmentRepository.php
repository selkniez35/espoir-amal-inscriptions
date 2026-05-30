<?php

namespace App\Repository;

use App\Entity\Enrollment;
use Doctrine\Persistence\ManagerRegistry;

class EnrollmentRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enrollment::class);
    }
}
