<?php

namespace App\Controller\Amqp\DeleteQuestion\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    /**
     * @param int $questionId
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $questionId
    ) {
    }
}
