<?php

namespace App\Enum;

enum EnrollmentStatus: string
{
    case PENDING = 'PENDING';
    case VALIDATED = 'VALIDATED';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::VALIDATED => 'Validé',
        };
    }
}
