<?php

namespace App\Domain\Repository\Group;

use App\Domain\DTO\PaginationDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;

interface GroupRepositoryInterface
{
    /**
     * @param int $groupId
     *
     * @return null|Group
     */
    public function findGroupById(int $groupId): ?Group;

    /**
     * @param Group $group
     *
     * @return int
     */
    public function create(Group $group): int;

    /**
     * @param Group $group
     *
     * @return void
     */
    public function activate(Group $group): void;

    /**
     * @param Group $group
     * @param User $user
     *
     * @return Group
     */
    public function addParticipant(Group $group, User $user): Group;

    /**
     * @param Group $group
     * @param User $user
     *
     * @return Group
     */
    public function removeParticipant(Group $group, User $user): Group;

    /**
     * @param PaginationDTO $paginationDTO
     * @param bool $ignoreIsActiveFilter
     *
     * @return array
     */
    public function getList(PaginationDTO $paginationDTO, bool $ignoreIsActiveFilter): array;

    /**
     * @param int $userId
     * @param PaginationDTO $paginationDTO
     * @param bool $ignoreIsActiveFilter
     *
     * @return array
     */
    public function getListWithIsParticipant(
        int $userId,
        PaginationDTO $paginationDTO,
        bool $ignoreIsActiveFilter = false
    ): array;

    /**
     * @param int $groupId
     *
     * @return void
     */
    public function delete(int $groupId): void;

    /**
     * @return void
     */
    public function update(): void;
}
