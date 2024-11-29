<?php

namespace App\Controller\Web\Workshop\CreateWorkshop\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateWorkshopDTO
{
    /**
     * @param string $title
     * @param string $description
     */
    public function __construct(
        #[Assert\Length(min: 1, max: 100)]
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public string $title,
        #[Assert\Length(min: 1, max: 255)]
        #[Assert\Type('string')]
        #[Assert\NotBlank]
        public string $description,
    ) {
    }
}
