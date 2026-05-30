<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Persistence\ManagerRegistry;

class CourseRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }
}
