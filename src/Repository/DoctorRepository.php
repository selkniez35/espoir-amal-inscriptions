<?php

namespace App\Repository;

use App\Entity\Doctor;
use Doctrine\Persistence\ManagerRegistry;

class DoctorRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Doctor::class);
    }
}
