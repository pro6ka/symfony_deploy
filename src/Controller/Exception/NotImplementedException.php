<?php

namespace App\Controller\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NotImplementedException extends Exception implements HttpComplaintExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return Response::HTTP_NOT_IMPLEMENTED;
    }

    /**
     * @inheritDoc
     */
    public function getHttpResponseBody(): string
    {
        return 'Not Implemented';
    }
}
