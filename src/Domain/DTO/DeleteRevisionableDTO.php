<?php

namespace App\Domain\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class DeleteRevisionableDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $entityId,
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, normalizer: 'trim')]
        public string $routingKey
    ) {
    }
}
