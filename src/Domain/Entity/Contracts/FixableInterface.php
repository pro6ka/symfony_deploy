<?php

namespace App\Domain\Entity\Contracts;

interface FixableInterface extends RevisionableInterface
{
    /**
     * @return int
     */
    public function getId(): int;
}
