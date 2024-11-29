<?php

namespace App\Controller\Amqp\DeleteAnswer\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    /**
     * @param int $entityId
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $entityId
    ) {
    }
}
