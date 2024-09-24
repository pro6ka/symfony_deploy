<?php

namespace App\Domain\Service;

use App\Domain\Entity\Contracts\HasFixationsInterface;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\FixationRepository;
use Doctrine\Common\Collections\ArrayCollection;

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

    /**
     * @param User $user
     * @param string $entityType
     *
     * @return ArrayCollection|array
     */
    public function findForUser(User $user, string $entityType): ArrayCollection|array
    {
        return $this->fixationRepository->findForUser($user, $entityType);
    }
}
