<?php

namespace App\Enum;

enum EmergencyContactTypeEnum: string
{
    case EMERGENCY = 'emergency';
    case SECONDARY = 'secondary';
    case DOCTOR = 'doctor';

    public function label(): string
    {
        return match ($this) {
            self::EMERGENCY => 'Contact d’urgence',
            self::SECONDARY => 'Contact secondaire',
            self::DOCTOR => 'Médecin traitant',
        };
    }
}
