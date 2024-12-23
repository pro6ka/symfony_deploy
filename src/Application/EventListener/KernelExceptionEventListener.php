<?php

namespace App\Application\EventListener;

use App\Controller\Exception\HttpComplaintExceptionInterface;
use App\Domain\Exception\WorkshopAccessExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class KernelExceptionEventListener
{
    private const string DEFAULT_PROPERTY = 'error';

    /**
     * @param ExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpComplaintExceptionInterface) {
            $event->setResponse($this->getHttpResponse($exception->getHttpResponseBody(), $exception->getHttpCode()));
        } elseif ($exception instanceof WorkshopAccessExceptionInterface) {
            $event->setResponse($this->getWorkshopAccessResponse($exception));
        } else {
            if ($exception instanceof HttpExceptionInterface) {
                $event->setResponse($this->getHttpResponse(
                    $exception->getMessage(),
                    $exception->getStatusCode()
                ));
            }

            if ($exception instanceof ValidationFailedException) {
                $event->setResponse($this->getValidationFailedResponse($exception));
            }
        }
    }

    /**
     * @param WorkshopAccessExceptionInterface $exception
     *
     * @return JsonResponse
     */
    private function getWorkshopAccessResponse(WorkshopAccessExceptionInterface $exception): JsonResponse
    {
        return new JsonResponse(['message' => $exception->getHttpResponseBody()]);
    }

    /**
     * @param ValidationFailedException $exception
     *
     * @return Response
     */
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
     * @param int $code
     *
     * @return Response
     */
    private function getHttpResponse($message, int $code = 500): Response
    {
        return new JsonResponse(['message' => $message], $code);
    }
}
