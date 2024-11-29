<?php

namespace App\Domain\Exception;

interface WorkshopAccessExceptionInterface
{
    /**
     * @return string
     */
    public function getHttpResponseBody(): string;
}
