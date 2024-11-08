<?php

namespace App\Domain\Model\User;

readonly class WorkShopAuthorModel
{
    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param null|string $middleName
     */
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public ?string $middleName
    ) {
    }
}
