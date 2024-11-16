<?php

namespace Tests\Unit\Service;

use App\Domain\Bus\DeleteRevisionableBusInterface;
use App\Domain\Entity\WorkShop;
use App\Domain\Exception\EntityHasFixationsException;
use App\Domain\Repository\WorkShop\WorkShopRepositoryCacheInterface;
use App\Domain\Service\FixationService;
use App\Domain\Service\RevisionService;
use App\Domain\Service\UserService;
use App\Domain\Service\WorkShopService;
use App\Tests\Support\UnitTester;
use Codeception\Test\Unit;
use Generator;
use Mockery;
use Mockery\Exception\RuntimeException;
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
        $workShopService = $this->prepareWorkShopService(true);
        $workShopService->deleteRevisionable($workShop);
        $this->assertTrue(true);
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
     * @param bool $withoutFixation
     *
     * @return WorkShopService
     * @throws ReflectionException
     * @throws RuntimeException
     */
    private function prepareWorkShopService(bool $withoutFixation = false): WorkShopService
    {
        return new WorkShopService(
            validator: Mockery::mock(ValidatorInterface::class),
            userService: Mockery::mock(UserService::class),
            fixationService: $this->prepareFixationService(),
            security: Mockery::mock(Security::class),
            workShopRepository: Mockery::mock(WorkShopRepositoryCacheInterface::class),
            deleteRevisionableBus: Mockery::mock(DeleteRevisionableBusInterface::class),
            revisionService: $this->prepareRevisionService($withoutFixation)
        );
    }
}
