<?php

namespace App\Controller\Web\Workshop\ShowWorkshop\v1\Output\Part;

use App\Controller\DTO\OutputDTOInterface;

readonly class ShowWorkshopStudentDTO implements OutputDTOInterface
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
