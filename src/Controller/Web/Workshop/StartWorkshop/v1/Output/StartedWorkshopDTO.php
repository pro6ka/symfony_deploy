<?php

namespace App\Controller\Web\Workshop\StartWorkshop\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class StartedWorkshopDTO implements OutputDTOInterface
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param array $exercises
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        /** @var StartedWorkshopExerciseDTO[] */
        public array $exercises = [],
    ) {
    }
}
