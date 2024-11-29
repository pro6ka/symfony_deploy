<?php

namespace App\Domain\ValueObject;

enum AppRolesEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_USER = 'ROLE_USER';
    case ROLE_STUDENT = 'ROLE_STUDENT';
    case ROLE_TEACHER = 'ROLE_TEACHER';
}
