<?php

namespace App\Tests\Functional\Controller\ShowWorkShop\v1;

// phpcs:disable PSR2.Methods.MethodDeclaration.Underscore

use App\Controller\Web\Workshop\ShowWorkshop\v1\Manager;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopDTO;
use App\Controller\Web\Workshop\ShowWorkshop\v1\Output\ShowWorkshopForTeacherDTO;
use App\Domain\Entity\Group;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Tests\Support\FunctionalTester;
use Codeception\Exception\InjectionException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Support\Helper\Factories;

class ManagerCest
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
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testNotAuthorized(FunctionalTester $I): void
    {
        /** @var Manager $manager */
        $manager = $I->grabService(Manager::class);
        $result = $manager->showWorkshop($this->workShopId);
        $I->assertInstanceOf(ShowWOrkShopDTO::class, $result);
    }

    /**
     * @throws InjectionException
     */
    public function testWorkShopForRoleTeacherInstanceOfShowWorkshopForTeacherDTO(FunctionalTester $I): void
    {
        $manager = $I->grabService(Manager::class);
        /** @var User $userRoleTeacher */
        $this->userRoleUser->setAppRoles([...$this->userRoleUser->getRoles(), 'ROLE_TEACHER']);
        $I->amLoggedInAs($this->userRoleUser);
        $I->canSeeUserHasRole('ROLE_TEACHER');
        $result = $manager->showWorkShop($this->workShopId);
        $I->assertInstanceOf(ShowWorkshopForTeacherDTO::class, $result);
    }
}
