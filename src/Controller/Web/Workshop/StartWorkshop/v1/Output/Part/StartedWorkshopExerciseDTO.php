<?php

namespace App\Controller\Web\Workshop\StartWorkshop\v1\Output\Part;

readonly class StartedWorkshopExerciseDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $content
     * @param int $countQuestions
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public int $countQuestions = 0
    ) {
    }
}
