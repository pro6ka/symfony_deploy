<?php

namespace App\Controller\Web\Question\EditQuestion\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class EditQuestionDTO
{
    /**
     * @param string $title
     * @param string $description
     */
    public function __construct(
        #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 100)]
        public string $title,
        #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 100)]
        public string $description
    ) {
    }
}
