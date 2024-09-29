<?php

namespace App\Domain\ValueObject;

enum UserRoleEnum: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
}
