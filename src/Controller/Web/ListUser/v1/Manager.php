<?php

namespace App\Controller\Web\ListUser\v1;

use App\Controller\Web\ListUser\v1\Output\ListUserItemDTO;
use App\Domain\Model\ListUserItemModel;
use App\Domain\Service\UserService;

readonly class Manager
{
    public function __construct(
       private UserService $userService
    ) {
    }

    public function getList(int $page)
    {
        return array_map(function (ListUserItemModel $user) {
            return new ListUserItemDTO(
                id: $user->id,
                login: $user->login,
                firstName: $user->firstname,
                lastName: $user->lastName,
                middleName: $user->middleName,
                email: $user->email,
                createdAt: $user->createdAt,
                updatedAt: $user->updatedAt,
                userRole: $user->userRole
            );
        }, $this->userService->getList($page));
    }
}
