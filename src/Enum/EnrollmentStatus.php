<?php
namespace App\Enum;

enum EnrollmentStatus: string
{
    case PENDING = 'PENDING';
    case VALIDATED = 'VALIDATED';
    case REJECTED = 'REJECTED';
}
