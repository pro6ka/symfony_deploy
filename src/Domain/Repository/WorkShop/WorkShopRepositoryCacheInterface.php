<?php

namespace App\Domain\Repository\WorkShop;

use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Model\Workshop\WorkShopModel;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface WorkShopRepositoryCacheInterface
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function findForUser(User $user): array;

    /**
     * @param WorkShop $workShop
     *
     * @return int
     */
    public function create(WorkShop $workShop): int;

    /**
     * @param int $id
     * @param User $user
     *
     * @return null|WorkShop
     */
    public function findForUserById(int $id, User $user): ?WorkShopModel;

    /**
     * @param int $id
     *
     * @return null|WorkShopModel
     */
    public function findById(int $id): ?WorkShopModel;

    /**
     * @param int $id
     *
     * @return null|WorkShop
     */
    public function findEntityById(int $id): ?WorkShop;


    /**
     * @param int $pageSize
     * @param int $firstResult
     *
     * @return Paginator
     */
    public function getList(int $pageSize, int $firstResult = 0): Paginator;

    /**
     * @param WorkShop $workshop
     *
     * @return void
     */
    public function removeWorkshop(WorkShop $workshop): void;

    /**
     * @param WorkShop $workShop
     * @param Group $group
     *
     * @return WorkShop
     */
    public function addParticipantsGroup(WorkShop $workShop, Group $group): WorkShop;


    /**
     * @param WorkShop $workShop
     * @param Group $group
     *
     * @return WorkShop
     */
    public function removeParticipantsGroup(WorkShop $workShop, Group $group): WorkShop;

    /**
     * @param $workShopId
     * @param $userId
     *
     * @return void
     */
    public function flushForStartedCache($workShopId, $userId): void;

    /**
     * @return void
     */
    public function update(): void;
}
