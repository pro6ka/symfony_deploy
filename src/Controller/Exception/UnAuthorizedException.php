<?php

namespace App\Controller\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UnAuthorizedException extends Exception implements HttpComplaintExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }

    /**
     * @inheritDoc
     */
    public function getHttpResponseBody(): string
    {
        return empty($this->getMessage()) ? 'Unauthorized' : $this->getMessage();
    }
}
