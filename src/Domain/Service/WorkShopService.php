<?php

namespace App\Domain\Service;

use App\Domain\Entity\Fixation;
use App\Domain\Entity\Revision;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Infrastructure\Repository\WorkShopRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;

readonly class WorkShopService
{
    /**
     * @param FixationService $fixationService
     * @param WorkShopRepository $workShopRepository
     */
    public function __construct(
        private FixationService $fixationService,
        private WorkShopRepository $workShopRepository
    ) {
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function listForUser(User $user): array
    {
        $workShopList = $this->workShopRepository->findForUser($user);
        $fixations = $this->fixationService->findForUser($user, WorkShop::class);
        $revisions = array_reduce(
            $fixations->toArray(),
            function ($carry, Fixation $fixation) {
                $carry[$fixation->getRevisions()->getEntityId()] = $fixation->getRevision();
                return $carry;
            },
        );

        foreach ($workShopList as $workShop) {
            /** @var Revision $revision */
            if (isset($revisions[$workShop->getId()])) {
                $revision = $revisions[$workShop->getId()];
                $setter = 'set' . ucfirst($revision->getColumnName());
                if (method_exists($workShop, $setter)) {
                    $workShop->$setter($revision->getContentAfter());
                }
            }
        }

        return $workShopList;
    }

    /**
     * @param int $workshopId
     *
     * @return null|WorkShop
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findById(int $workshopId): ?WorkShop
    {
        return $this->workShopRepository->findById($workshopId);
    }

    /**
     * @param int $id
     * @param User $user
     *
     * @return null|WorkShop
     * @throws NonUniqueResultException
     */
    public function findForUserById(int $id, User $user): ?WorkShop
    {
        return $this->workShopRepository->findForUserById($id, $user);
    }
}
