<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\Contracts\HasRevisionsInterface;
use App\Infrastructure\Repository\FixationRepository;

readonly class FixationService
{
    /**
     * @param FixationRepository $fixationRepository
     */
    public function __construct(
        private FixationRepository $fixationRepository
    ) {
    }

    /**
     * @param HasFixationsInterface $user
     *
     * @return void
     */
    public function removeByOwner(HasFixationsInterface $user): void
    {
        $this->fixationRepository->removeByOwner($user);
    }
}
