<?php

namespace App\Domain\Entity\Contracts;

interface HasRevisionsInterface
{
    /**
     * @return int
     */
    public function getId(): int;
}
