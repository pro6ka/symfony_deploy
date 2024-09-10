<?php

namespace App\Controller\Web\CreateUser\v1\Output;

use DateTime;

readonly class CreatedUserDTO
{
    public function __construct(
        public int $id,
        public string $login,
        public string $firstName,
        public string $lastName,
        public string $email,
        public DateTime $createdAt,
        public ?string $middleName = null,
    ) {
    }
}
