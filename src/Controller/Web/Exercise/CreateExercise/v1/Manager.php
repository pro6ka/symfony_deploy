<?php

namespace App\Controller\Web\Exercise\CreateExercise\v1;

use App\Controller\Web\Exercise\CreateExercise\v1\Input\CreateExerciseDTO;
use App\Controller\Web\Exercise\CreateExercise\v1\Output\CreatedExerciseDTO;
use App\Domain\Model\Exercise\CreateExerciseModel;
use App\Domain\Service\ExerciseService;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class Manager
{
    /**
     * @param ModelFactory $modelFactory
     * @param ExerciseService $exerciseService
     * @param WorkShopService $workShopService
     */
    public function __construct(
        private ModelFactory $modelFactory,
        private ExerciseService $exerciseService,
        private WorkShopService $workShopService
    ) {
    }

    /**
     * @param CreateExerciseDTO $createExerciseDTO
     *
     * @return CreatedExerciseDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createExercise(CreateExerciseDTO $createExerciseDTO): CreatedExerciseDTO
    {
        $workshop = $this->workShopService->findWorkshopById($createExerciseDTO->workshopId);

        if (! $workshop) {
            throw new BadRequestHttpException(sprintf('Workshop id: %d not found', $createExerciseDTO->workshopId));
        }

        $createExerciseModel = $this->modelFactory->makeModel(
            CreateExerciseModel::class,
            $createExerciseDTO->title,
            $createExerciseDTO->content,
            $workshop
        );

        $exercise = $this->exerciseService->create($createExerciseModel);

        return new CreatedExerciseDTO(
            id: $exercise->getId(),
            title: $exercise->getTitle(),
            content: $exercise->getContent(),
        );
    }
}
