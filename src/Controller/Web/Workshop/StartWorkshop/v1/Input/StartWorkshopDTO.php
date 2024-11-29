<?php

namespace App\Controller\Web\Workshop\StartWorkshop\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class StartWorkshopDTO
{
    /**
     * @param int $workshopId
     * @param int $groupId
     */
    public function __construct(
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        #[Assert\NotBlank]
        public int $workshopId,
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        #[Assert\NotBlank]
        public int $groupId
    ) {
    }
}
