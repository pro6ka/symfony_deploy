<?php

namespace App\Controller\Web\Workshop\ShowWorkshop\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use DateTime;

readonly class ShowWorkshopForTeacherDTO implements OutputDTOInterface, ShowWorkshopDTOInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param ListWorkshopAuthorDTO $author
     * @param array $students
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ListWorkshopAuthorDTO $author,
        /** @var array|ShowWOrkshopStudentDTO[] */
        public array $students,
    ) {
    }
}
