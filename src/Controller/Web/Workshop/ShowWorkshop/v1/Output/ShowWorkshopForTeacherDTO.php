<?php

namespace App\Controller\Web\Workshop\ShowWorkshop\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\Part\ShowWorkshopAuthorDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\Part\ShowWorkshopStudentDTO;
use DateTime;

readonly class ShowWorkshopForTeacherDTO implements OutputDTOInterface, ShowWorkshopDTOInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param ShowWorkshopAuthorDTO $author
     * @param array $students
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ShowWorkshopAuthorDTO $author,
        /** @var array|ShowWOrkshopStudentDTO[] */
        public array $students,
    ) {
    }
}
