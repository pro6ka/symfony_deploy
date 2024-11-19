<?php

namespace Tests\Functional\Service;

use App\Domain\Entity\User;
use App\Domain\Service\WorkShopService;
use Codeception\Exception\InjectionException;
use App\Tests\Support\FunctionalTester;
use Support\Helper\Factories;

class WorkShopServiceCest
{
    private const string ROLE_USER = 'role_user_login';

    /**
     * @param FunctionalTester $I
     *
     * @return void
     */
    public function _before(FunctionalTester $I): void
    {
    }

    /**
     * @throws InjectionException
     */
    public function testWorkShopShowForRoleUser(FunctionalTester $I)
    {
        /** @var User $user */
        $user = $I->have(User::class, ['login' => Factories::ROLE_USER]);
        $I->amHttpAuthenticated($user->getLogin(), $user->getPassword());
        $I->am('ROLE_USER');
        $I->seeUserHasRoles(['ROLE_USER']);

        /** @var WorkShopService $workShopService */
        $workShopService = $I->grabService(WorkShopService::class);
//        $workShopService->findForUserById()
    }
}
