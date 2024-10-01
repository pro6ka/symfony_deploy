<?php

namespace App\Application\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class KernelExceptionEventListener
{
    private const DEFAULT_PROPERTY = 'error';

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface) {
            $exception = $exception->getPrevious();
        }

        if ($exception instanceof ValidationFailedException) {
            $event->setResponse($this->getValidationFailedResponse($exception));
        }
    }

    private function getValidationFailedResponse(ValidationFailedException $exception): Response
    {
        $response = [];

        foreach ($exception->getViolations() as $violation) {
            $property = empty($violation->getPropertyPath()) ? self::DEFAULT_PROPERTY : $violation->getPropertyPath();
            $response[$property] = $violation->getMessage();
        }

        return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param $message
     * @param $code
     *
     * @return Response
     */
    private function getHttpResponse($message, $code = 500): Response
    {
        return new JsonResponse(['message' => $message], 500);
    }
}
