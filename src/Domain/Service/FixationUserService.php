<?php

namespace App\Domain\Service;

use App\Domain\Entity\Fixation;
use App\Domain\Entity\FixationUser;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\FixationUserRepository;

readonly class FixationUserService
{
    /**
     * @param FixationUserRepository $fixationUserRepository
     */
    public function __construct(
        private FixationUserRepository $fixationUserRepository
    ) {
    }

    /**
     * @param User $user
     * @param null|Fixation $fixation
     *
     * @return FixationUser
     */
    public function build(User $user, ?Fixation $fixation = null): FixationUser
    {
        $fixationUser = new FixationUser();
        $fixationUser->setUser($user);
        $fixationUser->setFixation($fixation);

        return $this->fixationUserRepository->create($fixationUser, false);
    }
}
