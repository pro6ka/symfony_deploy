<?php

namespace App\Controller\Web\Workshop\CreateWorkshop\v1;

use App\Controller\Web\Workshop\CreateWorkshop\v1\Input\CreateWorkshopDTO;
use App\Controller\Web\Workshop\CreateWorkshop\v1\Output\CreatedWorkshopDTO;
use App\Controller\Web\Workshop\CreateWorkshop\v1\Output\WorkshopAuthorDTO;
use App\Domain\Model\Workshop\CreateWorkshopModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkShopService;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class Manager
{
    /**
     * @param ModelFactory $modelFactory
     * @param WorkShopService $workShopService
     */
    public function __construct(
        private ModelFactory $modelFactory,
        private WorkShopService $workShopService,
    ) {
    }

    /**
     * @param CreateWorkshopDTO $createWorkshopDTO
     * @param UserInterface $authUser
     *
     * @return CreatedWorkshopDTO
     */
    public function createWorkshop(CreateWorkshopDTO $createWorkshopDTO, UserInterface $authUser): CreatedWorkshopDTO
    {
        $createWorkshopModel = $this->modelFactory->makeModel(
            CreateWorkshopModel::class,
            $createWorkshopDTO->title,
            $createWorkshopDTO->description,
            $authUser->getUserIdentifier()
        );

        $workshop = $this->workShopService->create($createWorkshopModel);

        return new CreatedWorkshopDTO(
            id: $workshop->getId(),
            title: $workshop->getTitle(),
            description: $workshop->getDescription(),
            createdAt: $workshop->getCreatedAt(),
            author: new WorkshopAuthorDTO(
                id: $workshop->getAuthor()->getId(),
                firstName: $workshop->getAuthor()->getFirstName(),
                lastName: $workshop->getAuthor()->getLastName()
            )
        );
    }
}
