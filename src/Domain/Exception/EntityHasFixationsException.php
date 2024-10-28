<?php

namespace App\Domain\Exception;

use App\Domain\Entity\Contracts\FixableInterface;
use Throwable;

class EntityHasFixationsException extends \Exception
{
    /**
     * @param FixableInterface $entity
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        FixableInterface $entity,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf('Entity id [%d] has fixations', $entity->getId()),
            $code,
            $previous
        );
    }
}
