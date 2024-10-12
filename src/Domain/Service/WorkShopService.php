<?php

namespace App\Domain\Service;

use App\Domain\Entity\Fixation;
use App\Domain\Entity\Revision;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Model\Workshop\CreateWorkshopModel;
use App\Infrastructure\Repository\WorkShopRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class WorkShopService
{
    /**
     * @param FixationService $fixationService
     * @param WorkShopRepository $workShopRepository
     */
    public function __construct(
        private ValidatorInterface $validator,
        private UserService $userService,
        private FixationService $fixationService,
        private WorkShopRepository $workShopRepository
    ) {
    }

    public function create(CreateWorkshopModel $createWorkshopModel)
    {
        $author = $this->userService->findUserByLogin($createWorkshopModel->authorIdentifier);
        $workshop = new WorkShop();
        $workshop->setTitle($createWorkshopModel->title);
        $workshop->setDescription($createWorkshopModel->description);
        $workshop->setAuthor($author);

        $violations = $this->validator->validate($workshop);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($workshop, $violations);
        }

        $this->workShopRepository->create($workshop);

        return $workshop;
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
