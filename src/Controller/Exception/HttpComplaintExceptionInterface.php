<?php

namespace App\Controller\Exception;

interface HttpComplaintExceptionInterface
{
    /**
     * @return int
     */
    public function getHttpCode(): int;

    /**
     * @return string
     */
    public function getHttpResponseBody(): string;
}
