<?php

namespace App\Controller\Web\Workshop\ShowWorkshop\v1;

use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopAuthorDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopDTOInterface;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopForTeacherDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopStudentDTO;
use App\Domain\Entity\User;
use App\Domain\Service\WorkShopService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
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
     * @return ShowWorkshopForTeacherDTO
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function showWorkshop(int $workshopId): ShowWorkshopDTOInterface
    {
        if ($workshop = $this->workShopService->findById($workshopId)) {
            if ($this->security->isGranted('ROLE_TEACHER')) {
                return new ShowWorkshopForTeacherDTO(
                    id: $workshop->getId(),
                    title: $workshop->getTitle(),
                    description: $workshop->getDescription(),
                    createdAt: $workshop->getCreatedAt(),
                    updatedAt: $workshop->getUpdatedAt(),
                    author: new ShowWorkshopAuthorDTO(
                        id: $workshop->getAuthor()->getId(),
                        firstName: $workshop->getAuthor()->getFirstName(),
                        lastName: $workshop->getAuthor()->getLastName()
                    ),
                    students: $workshop->getStudents()->map(function (User $student) {
                        return new ShowWorkshopStudentDTO(
                            id: $student->getId(),
                            firstName: $student->getFirstName(),
                            lastName: $student->getLastName()
                        );
                    })->toArray()
                );
            }
            return new ShowWorkshopDTO(
                id: $workshop->getId(),
                title: $workshop->getTitle(),
                description: $workshop->getDescription(),
                createdAt: $workshop->getCreatedAt(),
                updatedAt: $workshop->getUpdatedAt(),
                author: new ShowWorkshopAuthorDTO(
                    id: $workshop->getAuthor()->getId(),
                    firstName: $workshop->getAuthor()->getFirstName(),
                    lastName: $workshop->getAuthor()->getLastName()
                )
            );
        }

        throw new NotFoundHttpException(sprintf('Workshop id: %d not found', $workshopId));
    }
}
