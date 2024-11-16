<?php

namespace Tests\Unit\Service;

use App\Application\Security\AuthUser;
use App\Domain\Bus\DeleteRevisionableBusInterface;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use App\Domain\Exception\EntityHasFixationsException;
use App\Domain\Model\Workshop\WorkShopModel;
use App\Domain\Repository\WorkShop\WorkShopRepositoryCacheInterface;
use App\Domain\Service\FixationService;
use App\Domain\Service\RevisionService;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkShopService;
use App\Tests\Support\UnitTester;
use Codeception\Test\Unit;
use Doctrine\ORM\Exception\ORMException;
use Generator;
use Mockery;
use Mockery\Exception\RuntimeException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WorkShopServiceTest extends Unit
{
    protected UnitTester $tester;

    /**
     * @param WorkShop $workShop
     *
     * @return void
     * @throws EntityHasFixationsException
     * @throws ReflectionException
     * @throws RuntimeException
     *
     * @dataProvider createTestCases
     */
    public function testDeleteRevisionableException(WorkShop $workShop): void
    {
        $workShopService = $this->prepareWorkShopService();
        static::expectException(EntityHasFixationsException::class);
        $workShopService->deleteRevisionable($workShop);
    }

    /**
     * @param WorkShop $workShop
     *
     * @return void
     * @throws EntityHasFixationsException
     * @throws ReflectionException
     * @throws RuntimeException
     *
     * @dataProvider createTestCases
     */
    public function testDeleteRevisionableWithoutFixations(WorkShop $workShop): void
    {
        $workShop->setId(2);
        $workShopService = $this->prepareWorkShopService('', true);
        $workShopService->deleteRevisionable($workShop);
        $this->assertTrue(true);
    }

    /**
     * @return void
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws ORMException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testFindWorkShopById(): void
    {
        $workShopService = $this->prepareWorkShopService();
        $result = $workShopService->findWorkshopById(1);
        static::assertInstanceOf(WorkShopModel::class, $result);
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function testFindWorkShopByIdForAll(): void
    {
        $workShopService = $this->prepareWorkShopService('ANY_ROLE');
        $result = $workShopService->findWorkshopById(1);
        static::assertInstanceOf(WorkShopModel::class, $result);
    }

    /**
     * @return Generator
     */
    public static function createTestCases(): Generator
    {
        $withFixationsWorkShop = new WorkShop();
        $withFixationsWorkShop->setId(1);

        yield [$withFixationsWorkShop];
    }

    /**
     * @param bool $withoutFixation
     *
     * @return RevisionService
     * @throws ReflectionException
     * @throws RuntimeException
     */
    private function prepareRevisionService(bool $withoutFixation = false): RevisionService
    {
        $revisionService = Mockery::mock(RevisionService::class);

        if ($withoutFixation) {
            $revisionService->shouldReceive('removeByOwner')
                ->getMock()
                ->expects($this->exactly(1))
            ;
        }

        return $revisionService;
    }

    /**
     * @return FixationService
     * @throws ReflectionException
     * @throws RuntimeException
     */
    private function prepareFixationService(): FixationService
    {

        $fixationService = Mockery::mock(FixationService::class);
        $fixationService->shouldReceive('findByEntity')
            ->andReturnUsing(fn (WorkShop $workShop) => $workShop->getId() === 1 ? [true] : []);

        return $fixationService;
    }

    /**
     * @param string $role
     *
     * @return Security
     * @throws ReflectionException
     * @throws RuntimeException
     */
    private function prepareSecurity(string $role): Security
    {
        $authUser = Mockery::mock(AuthUser::class);
        $authUser->shouldReceive('getUserIdentifier')
            ->andReturn('username');

        $security = Mockery::mock(Security::class);
        $security->shouldReceive('isGranted')
            ->andReturnUsing(fn (string $role) => $role === 'ROLE_STUDENT')
            ->getMock();
        $security->shouldReceive('getUser')
            ->andReturn($authUser);

        return $security;
    }

    /**
     * @return UserService
     * @throws ReflectionException
     * @throws RuntimeException
     */
    private function prepareUserService(): UserService
    {
        $userService = Mockery::mock(UserService::class);
        $userService->shouldReceive('findUserByLogin')
            ->andReturn(new User());

        return $userService;
    }

    /**
     * @return WorkShopRepositoryCacheInterface
     * @throws ReflectionException
     * @throws RuntimeException
     */
    private function prepareWorkShopRepository(): WorkShopRepositoryCacheInterface
    {
        $workShopRepository = Mockery::mock(WorkShopRepositoryCacheInterface::class);
        $workShopRepository->shouldReceive('findForUserById')
            ->andReturn(Mockery::mock(WorkShopModel::class));

        return $workShopRepository;
    }

    /**
     * @param string $forUser
     * @param bool $withoutFixation
     *
     * @return WorkShopService
     * @throws ReflectionException
     * @throws RuntimeException
     */
    private function prepareWorkShopService(
        string $forUser = 'ROLE_STUDENT',
        bool $withoutFixation = false
    ): WorkShopService {
        return new WorkShopService(
            validator: Mockery::mock(ValidatorInterface::class),
            userService: $this->prepareUserService(),
            fixationService: $this->prepareFixationService(),
            security: $this->prepareSecurity($forUser),
            workShopRepository: $this->prepareWorkShopRepository(),
            deleteRevisionableBus: Mockery::mock(DeleteRevisionableBusInterface::class),
            revisionService: $this->prepareRevisionService($withoutFixation)
        );
    }
}
