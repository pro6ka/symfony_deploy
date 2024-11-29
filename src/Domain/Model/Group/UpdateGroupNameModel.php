<?php

namespace App\Domain\Model\Group;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateGroupNameModel
{
    /**
     * @param int $id
     * @param string $name
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $id,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $name
    ) {
    }
}
