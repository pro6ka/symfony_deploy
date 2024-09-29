<?php

namespace App\Domain\Service;

use App\Domain\Entity\Exercise;
use App\Domain\Entity\WorkShop;
use App\Infrastructure\Repository\ExerciseRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class ExerciseService
{
    /**
     * @param ExerciseRepository $exerciseRepository
     */
    public function __construct(
        private ExerciseRepository $exerciseRepository
    ) {
    }

    /**
     * @param string $title
     * @param string $content
     * @param WorkShop $workShop
     *
     * @return int
     */
    public function create(
        string $title,
        string $content,
        WorkShop $workShop
    ): int {
        $exercise = new Exercise();
        $exercise->setTitle($title);
        $exercise->setContent($content);
        $exercise->setWorkShop($workShop);

        return $this->exerciseRepository->create($exercise);
    }

    /**
     * @param int $exerciseId
     *
     * @return null|Exercise
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $exerciseId): ?Exercise
    {
        return $this->exerciseRepository->findById($exerciseId);
    }
}
