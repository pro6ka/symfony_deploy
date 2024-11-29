<?php

namespace App\Domain\Entity\Contracts;

interface ActivatedInterface
{
    /**
     * @return bool
     */
    public function getIsActive(): bool;

    /**
     * @param bool $isActive
     *
     * @return void
     */
    public function setIsActive(bool $isActive): void;
}
