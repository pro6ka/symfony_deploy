<?php

namespace App\Domain\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class PaginationDTO
{
    /**
     * @param int $pageSize
     * @param int $firstResult
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $pageSize,
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $page,
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThanOrEqual(0)]
        public int $firstResult = 0
    ) {
    }
}
