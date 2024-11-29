<?php

namespace Support\Helper;

// phpcs:disable PSR2.Methods.MethodDeclaration.Underscore

use App\Domain\Entity\Answer;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Group;
use App\Domain\Entity\Question;
use App\Domain\Entity\User;
use App\Domain\Entity\WorkShop;
use Codeception\Exception\ModuleException;
use Codeception\Module;
use DateTime;
use Exception;
use League\FactoryMuffin\Faker\Facade;

class Factories extends Module
{
    public const string ROLE_USER_LOGIN = 'role_user_login';

    /**
     * @param $settings
     *
     * @return void
     * @throws ModuleException
     * @throws Exception
     */
    public function _beforeSuite($settings = []): void
    {
        /** @var Module\DataFactory $factory */
        $factory = $this->getModule('DataFactory');

        $factory->_define(User::class, $this->getUserRoleUserData());
        $factory->_define(Group::class, $this->getGroupData());
        $factory->_define(
            WorkShop::class,
            $this->getWorkShopData(),
        );
        $factory->_define(Answer::class, ['id' => 3001]);
        $factory->_define(Question::class, ['id' => 2001]);
        $factory->_define(Exercise::class, $this->getExerciseData());
    }

    public function getExerciseData(): array
    {
        return [
            'id' => 1001,
            'title' => Facade::text(10),
            'content' => Facade::text(20),
        ];
    }

    /**
     * @return array
     */
    public function getWorkShopData(): array
    {
        return [
            'id' => 50,
            'title' => 'test workShop title',
            'description' => 'test workShop description',
            'createdAt' => (new DateTime())->modify('-10 days'),
            'updatedAt' => (new DateTime())->modify('-1 day'),
        ];
    }

    /**
     * @return array
     */
    public function getUserRoleUserData(): array
    {
        return [
            'id' => 10,
            'login' => static::ROLE_USER_LOGIN,
            'first_name' => Facade::text(10),
            'last_name' => Facade::text(10),
            'email' => Facade::email(),
            'password' => Facade::text(20),
            'roles' => ['ROLE_USER']
        ];
    }

    /**
     * @return array
     */
    public function getGroupData(): array
    {
        return [
            'id' => 100,
            'name' => 'test user/workshop group',
            'is_active' => true,
            'working_from' => (new DateTime())->modify('-1 day'),
            'working_to' => (new DateTime())->modify('+10 day'),
        ];
    }
}
