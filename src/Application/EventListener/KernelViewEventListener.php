<?php

namespace App\Application\EventListener;

use App\Controller\DTO\OutputDTOInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

readonly class KernelViewEventListener
{
    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(private SerializerInterface $serializer)
    {
    }

    /**
     * @param ViewEvent $event
     *
     * @return void
     */
    public function onKernelView(ViewEvent $event): void
    {
        $dto = $event->getControllerResult();

        if ($dto instanceof OutputDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto));
        }
    }

    /**
     * @param $data
     *
     * @return Response
     */
    private function getDTOResponse($data): Response
    {
        $serializedData = $this->serializer->serialize(
            $data,
            'json',
            [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
        );

        return new JsonResponse($serializedData, Response::HTTP_OK, [], true);
    }
}
