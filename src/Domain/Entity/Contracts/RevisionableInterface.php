<?php

namespace App\Domain\Entity\Contracts;

interface RevisionableInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return array
     */
    public function revisionableFields(): array;
}
