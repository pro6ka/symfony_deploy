<?php

namespace App\Controller\Amqp\WorkShop\StartWorkShop\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class Message
{
    /**
     * @param int $workShopId
     * @param int $userId
     * @param int $groupId
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
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\GreaterThan(0)]
        public int $groupId
    ) {
    }
}
