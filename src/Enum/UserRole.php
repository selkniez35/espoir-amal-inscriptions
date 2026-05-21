<?php

namespace App\Enum;

enum UserRole: string
{
    case USER = UserRole::USER->value;

    case ADMIN = UserRole::ADMIN->value;
}