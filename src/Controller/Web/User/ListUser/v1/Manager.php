<?php

namespace App\Controller\Web\User\ListUser\v1;

use App\Controller\Web\User\ListUser\v1\Output\ListUserItemDTO;
use App\Domain\Model\PaginationModel;
use App\Domain\Model\User\ListUserModel;
use App\Domain\Service\UserService;

readonly class Manager
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        private UserService $userService
    ) {
    }

    /**
     * @param int $page
     *
     * @return ListUserModel
     */
    public function getList(int $page): ListUserModel
    {
        $paginator = $this->userService->getList($page);
        $userList = [];

        foreach ($paginator as $user) {
            $userList[] = new ListUserItemDTO(
                id: $user->getId(),
                login: $user->getLogin(),
                firstName: $user->getFirstName(),
                lastName: $user->getLastName(),
                middleName: $user->getMiddleName(),
                email: $user->getEmail(),
                createdAt: $user->getCreatedAt(),
                updatedAt: $user->getUpdatedAt(),
                userRole: $user->getUserRole()
            );
        }

        return new ListUserModel(
            userList: $userList,
            pagination: new PaginationModel(
                total: $paginator->count(),
                page: $page,
                pageSize: ListUserMOdel::PAGE_SIZE
            )
        );
    }
}
