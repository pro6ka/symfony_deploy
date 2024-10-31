<?php

namespace App\Controller\Amqp\DeleteExercise\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    /**
     * @param int $exerciseId
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $exerciseId
    ) {
    }
}
