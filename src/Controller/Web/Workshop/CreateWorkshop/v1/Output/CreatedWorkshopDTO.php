<?php

namespace App\Controller\Web\Workshop\CreateWorkshop\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Controller\Web\Workshop\CreateWorkshop\v1\Output\Part\WorkshopAuthorDTO;
use DateTime;

readonly class CreatedWorkshopDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $createdAt
     * @param WorkshopAuthorDTO $author
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public DateTime $createdAt,
        public WorkshopAuthorDTO $author
    ) {
    }
}
