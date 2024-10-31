<?php

namespace App\Controller\Amqp\DeleteWorkShop\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    /**
     * @param int $workShopId
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $workShopId
    ) {
    }
}
