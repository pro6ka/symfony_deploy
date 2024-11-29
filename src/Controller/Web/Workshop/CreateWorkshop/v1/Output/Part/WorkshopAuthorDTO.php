<?php

namespace App\Controller\Web\Workshop\CreateWorkshop\v1\Output\Part;

readonly class WorkshopAuthorDTO
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
