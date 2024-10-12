<?php

namespace App\Controller\Web\WorkShop\RemoveParticipantsGroup\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AddParticipantsGroupDTO
{
    /**
     * @param int $groupId
     * @param int $workshopId
     */
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(1)]
        public int $groupId,
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(1)]
        public int $workshopId
    ) {
    }
}
