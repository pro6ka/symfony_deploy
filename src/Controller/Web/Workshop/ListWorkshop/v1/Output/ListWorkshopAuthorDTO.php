<?php

namespace App\Controller\Web\Workshop\ListWorkshop\v1\Output;

readonly class ListWorkshopAuthorDTO
{
    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName
    ) {
    }
}
