<?php

namespace App\Controller\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AccessDeniedException extends Exception implements HttpComplaintExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }

    /**
     * @inheritDoc
     */
    public function getHttpResponseBody(): string
    {
        return 'Access Denied';
    }
}
