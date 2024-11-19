<?php

namespace Support\Helper;

use App\Domain\Entity\User;
use Codeception\Exception\ModuleException;
use Codeception\Module;
use League\FactoryMuffin\Faker\Facade;

class Factories extends Module
{
    public const string ROLE_USER = 'role_user_login';

    /**
     * @param $settings
     *
     * @return void
     * @throws ModuleException
     */
    public function _beforeSuite($settings = [])
    {
        $factory = $this->getModule('DataFactory');

        $factory->_define(User::class, [
            'id' => 10,
            'login' => static::ROLE_USER,
            'first_name' => Facade::text(10),
            'last_name' => Facade::text(10),
            'email' => Facade::email(),
            'password' => Facade::text(20),
            'roles' => ['ROLE_USER']
        ]);
    }
}
