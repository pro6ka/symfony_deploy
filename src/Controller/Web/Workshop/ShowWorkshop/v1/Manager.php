<?php

namespace App\Controller\Web\Workshop\ShowWorkshop\v1;

use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\Part\ShowWorkshopAuthorDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\Part\ShowWorkshopStudentDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopDTOInterface;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopForTeacherDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Model\Group\GroupModel;
use App\Domain\Model\Workshop\WorkShopModel;
use App\Domain\Service\WorkShopService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    /**
     * @param Security $security
     * @param WorkShopService $workShopService
     */
    public function __construct(
        private Security $security,
        private WorkShopService $workShopService
    ) {
    }

    /**
     * @param int $workshopId
     *
     * @return ShowWorkshopDTOInterface
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function showWorkshop(int $workshopId): ShowWorkshopDTOInterface
    {
        /** @var WorkShopModel $workshop */
        if ($workshop = $this->workShopService->findWorkshopById($workshopId)) {
            if ($this->security->isGranted('ROLE_TEACHER')) {
                $studentsCollection = new ArrayCollection();
                /** @var GroupModel $group */
                foreach ($workshop->groupParticipants as $group) {
                    /** @var User $participant */
                    foreach ($group->participants as $participant) {
                        if (! $studentsCollection->containsKey($participant->getId())) {
                            $studentsCollection->set($participant->getId(), new ShowWorkshopStudentDTO(
                                id: $participant->getId(),
                                firstName: $participant->getFirstName(),
                                lastName: $participant->getLastName()
                            ));
                        }
                    }
                }

                return new ShowWorkshopForTeacherDTO(
                    id: $workshop->id,
                    title: $workshop->title,
                    description: $workshop->description,
                    createdAt: $workshop->createdAt,
                    updatedAt: $workshop->updatedAt,
                    author: new ShowWorkshopAuthorDTO(
                        id: $workshop->author->id,
                        firstName: $workshop->author->firstName,
                        lastName: $workshop->author->lastName
                    ),
                    students: $studentsCollection->toArray()
                );
            }

            return new ShowWorkshopDTO(
                id: $workshop->id,
                title: $workshop->title,
                description: $workshop->description,
                createdAt: $workshop->createdAt,
                updatedAt: $workshop->updatedAt,
                author: new ShowWorkshopAuthorDTO(
                    id: $workshop->author->id,
                    firstName: $workshop->author->firstName,
                    lastName: $workshop->author->lastName
                )
            );
        }

        throw new NotFoundHttpException(sprintf('Workshop id: %d was not found', $workshopId));
    }
}
