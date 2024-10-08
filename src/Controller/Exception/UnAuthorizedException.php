<?php

namespace App\Controller\Exception;

use Symfony\Component\HttpFoundation\Response;

class UnAuthorizedException extends \Exception implements HttpComplaintExceptionInterface
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
    public function getResponseBody(): string
    {
        return 'Unauthorized';
    }
}
