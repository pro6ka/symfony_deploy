<?php

namespace App\Controller\Web\Workshop\ShowWorkshop\v1;

use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ListWorkshopAuthorDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopDTOInterface;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopForTeacherDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopStudentDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
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
        if ($workshop = $this->workShopService->findWorkshopById($workshopId)) {
            if ($this->security->isGranted('ROLE_TEACHER')) {
                $studentsCollection = new ArrayCollection();
                /** @var Group $group */
                foreach ($workshop->getGroupsParticipants() as $group) {
                    /** @var User $participant */
                    foreach ($group->getParticipants() as $participant) {
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
                    id: $workshop->getId(),
                    title: $workshop->getTitle(),
                    description: $workshop->getDescription(),
                    createdAt: $workshop->getCreatedAt(),
                    updatedAt: $workshop->getUpdatedAt(),
                    author: new ListWorkshopAuthorDTO(
                        id: $workshop->getAuthor()->getId(),
                        firstName: $workshop->getAuthor()->getFirstName(),
                        lastName: $workshop->getAuthor()->getLastName()
                    ),
                    students: $studentsCollection->toArray()
                );
            }
            return new ShowWorkshopDTO(
                id: $workshop->getId(),
                title: $workshop->getTitle(),
                description: $workshop->getDescription(),
                createdAt: $workshop->getCreatedAt(),
                updatedAt: $workshop->getUpdatedAt(),
                author: new ListWorkshopAuthorDTO(
                    id: $workshop->getAuthor()->getId(),
                    firstName: $workshop->getAuthor()->getFirstName(),
                    lastName: $workshop->getAuthor()->getLastName()
                )
            );
        }

        throw new NotFoundHttpException(sprintf('Workshop id: %d not found', $workshopId));
    }
}
