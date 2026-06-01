<?php

namespace App\Enum;

enum EnrollmentStatus: string
{
    case PENDING = 'PENDING';
    case VALIDATED = 'VALIDATED';
    case REJECTED = 'REJECTED';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::VALIDATED => 'Validée',
            self::REJECTED => 'Rejetée',
        };
    }
}
