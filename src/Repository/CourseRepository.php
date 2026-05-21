<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function save(Course $course, bool $flush = true): void
    {
        $this->getEntityManager()->persist($course);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Course $course, bool $flush = true): void
    {
        $this->getEntityManager()->remove($course);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}