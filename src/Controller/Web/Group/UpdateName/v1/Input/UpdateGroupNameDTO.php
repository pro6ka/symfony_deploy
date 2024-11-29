<?php

namespace App\Controller\Web\Group\UpdateName\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateGroupNameDTO
{
    /**
     * @param string $name
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $name
    ) {
    }
}
