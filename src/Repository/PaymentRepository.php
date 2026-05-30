<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Persistence\ManagerRegistry;

class PaymentRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }
}
