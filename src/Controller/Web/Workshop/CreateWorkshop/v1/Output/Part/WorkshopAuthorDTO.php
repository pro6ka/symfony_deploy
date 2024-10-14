<?php

namespace App\Controller\Web\Workshop\CreateWorkshop\v1\Output\Part;

readonly class WorkshopAuthorDTO
{
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName
    ) {
    }
}
