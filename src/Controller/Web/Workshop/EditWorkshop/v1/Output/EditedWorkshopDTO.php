<?php

namespace App\Controller\Web\Workshop\EditWorkshop\v1\Output;

use DateTime;

readonly class EditedWorkshopDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public DateTime $createdAt,
        public DateTime $updatedAt,
    ) {
    }
}
