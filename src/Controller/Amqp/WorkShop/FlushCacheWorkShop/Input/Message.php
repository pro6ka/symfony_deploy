<?php

namespace App\Controller\Amqp\WorkShop\FlushCacheWorkShop\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class Message
{
    /**
     * @param int $workShopId
     * @param int $userId
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $workShopId,
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $userId,
    ) {
    }
}
