<?php

namespace Tests\Functional\Service;

use App\Domain\Model\Workshop\WorkShopModel;
use App\Tests\Support\FunctionalTester;
use Codeception\Exception\InjectionException;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Service\WorkShopService;
use Support\Helper\Factories;

class WorkShopServiceCest
{
    private const string ROLE_USER = 'role_user_login';
    private ?User $userRoleUser;
    private int $workShopId;

    /**
     * @param FunctionalTester $I
     *
     * @return void
     * @throws InjectionException
     */
    // phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
    public function _before(FunctionalTester $I): void
    {
        $this->userRoleUser = $I->have(User::class, ['login' => Factories::ROLE_USER_LOGIN]);
        /** @var Group $group */
        $group = $I->have(Group::class, ['id' => $I->getGroupData()['id']]);
        /** @var WorkShop $workShop */
        $this->userRoleUser->addGroup($group);
        $workShop = $I->have(WorkShop::class, ['id' => $I->getWorkShopData()['id']]);
        $workShop->setAuthor($I->make(User::class, []));
        $this->workShopId = $workShop->getId();
        $workShop->addGroupParticipant($group);
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     * @throws InjectionException
     */
    public function testWorkShopShowForRoleUserIsNotNull(FunctionalTester $I): void
    {
        /** @var WorkShopService $workShopService */
        $workShopService = $I->grabService(WorkShopService::class);
        $workShop = $workShopService->findForUserById($this->workShopId, $this->userRoleUser);
        $I->assertNotNull($workShop);
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     * @throws InjectionException
     */
    public function testWorkShopShowForRoleUserInstanceOfWorkShopModel(FunctionalTester $I): void
    {
        /** @var WorkShopService $workShopService */
        $workShopService = $I->grabService(WorkShopService::class);
        $workShop = $workShopService->findForUserById($this->workShopId, $this->userRoleUser);
        $I->assertInstanceOf(WorkShopModel::class, $workShop);
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     * @throws InjectionException
     */
    public function testWorkShopShowForRoleUserWithWrongIdIsNull(FunctionalTester $I): void
    {
        /** @var WorkShopService $workShopService */
        $workShopService = $I->grabService(WorkShopService::class);
        $workShop = $workShopService->findForUserById($this->workShopId + 1, $this->userRoleUser);
        $I->assertNull($workShop);
    }

    /**
     * @param FunctionalTester $I
     *
     * @return void
     * @throws InjectionException
     */
    public function testWorkShopShowForRoleUserWithRandomUserIsNull(FunctionalTester $I): void
    {
        /** @var WorkShopService $workShopService */
        $workShopService = $I->grabService(WorkShopService::class);
        $workShop = $workShopService->findForUserById(
            $this->workShopId,
            $I->make(User::class, ['id' => rand(1000, 10000)])
        );
        $I->assertNull($workShop);
    }
}
