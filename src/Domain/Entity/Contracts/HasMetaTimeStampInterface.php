<?php

namespace App\Domain\Entity\Contracts;

interface HasMetaTimeStampInterface
{
    /**
     * @return void
     */
    public function setCreatedAt(): void;

    /**
     * @return void
     */
    public function setUpdatedAt(): void;
}
