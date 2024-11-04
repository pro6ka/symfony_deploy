<?php

namespace App\Domain\DTO\Group;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GroupListInputDTO
{
    /**
     * @param int $userId
     * @param bool $ignoreIsActiveFilter
     * @param bool $isWithParticipant
     * @param int $page
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $userId,
        #[Assert\Type('boolean')]
        public bool $ignoreIsActiveFilter = false,
        #[Assert\Type('boolean')]
        public bool $isWithParticipant = false,
        #[Assert\Type('integer')]
        public int $page = 1
    ) {
    }
}
