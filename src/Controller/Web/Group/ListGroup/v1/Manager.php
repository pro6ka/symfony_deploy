<?php

namespace App\Controller\Web\Group\ListGroup\v1;

use App\Application\Security\AuthUser;
use App\Controller\Web\Group\ListGroup\v1\Output\GroupListDTO;
use App\Controller\Web\Group\ListGroup\v1\Output\Part\GroupListItemDTO;
use App\Domain\DTO\Group\GroupListInputDTO;
use App\Domain\DTO\Group\GroupListOutputDTO;
use App\Domain\Entity\Group;
use App\Domain\Model\Group\GroupListModel;
use App\Domain\Model\PaginationModel;
use App\Domain\Service\GroupService;
use App\Domain\Service\UserService;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Manager
{
    /**
     * @param Security $security
     * @param UserService $userService
     * @param ValidatorInterface $validator
     * @param GroupService $groupService
     */
    public function __construct(
        private Security $security,
        private UserService $userService,
        private ValidatorInterface $validator,
        private GroupService $groupService
    ) {
    }

    /**
     * @param int $page
     * @param AuthUser $currentUser
     *
     * @return GroupListDTO
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function showList(int $page, AuthUser $currentUser): GroupListDTO
    {
        $user = $this->userService->findUserByLogin($currentUser->getUserIdentifier());
        $groupListServiceDTO = new GroupListInputDTO(
            userId: $user->getId(),
            ignoreIsActiveFilter: $this->security->isGranted('ROLE_GROUP_EDITOR'),
            isWithParticipant: $this->security->isGranted('ROLE_VIEW_GROUP'),
            page: $page
        );

        $violations = $this->validator->validate($groupListServiceDTO);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($groupListServiceDTO, $violations);
        }

        $groupList = $this->groupService->showList($groupListServiceDTO);

        return new GroupListDTO(
            groupList: $groupList->groups,
            pagination: $groupList->pagination
        );
    }
}
