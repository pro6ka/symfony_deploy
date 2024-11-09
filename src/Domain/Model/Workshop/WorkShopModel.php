<?php

namespace App\Domain\Model\Workshop;

use App\Domain\Model\Exercise\ExerciseModel;
use App\Domain\Model\Group\GroupModel;
use App\Domain\Model\User\WorkShopAuthorModel;
use DateTime;

readonly class WorkShopModel
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param WorkShopAuthorModel $author
     * @param array|ExerciseModel[] $exercises
     * @param array|GroupModel[] $groupParticipants
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public WorkShopAuthorModel $author,
        public array $exercises = [],
        public array $groupParticipants = [],
    ) {
    }
}
