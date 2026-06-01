<?php

namespace App\Repository;

use App\Entity\Child;
use Doctrine\Persistence\ManagerRegistry;

class ChildRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Child::class);
    }
}
