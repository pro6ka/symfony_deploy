<?php

namespace App\Controller\Web\Workshop\ShowWorkshop\v1\Output;

readonly class ShowWorkshopAuthorDTO
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
