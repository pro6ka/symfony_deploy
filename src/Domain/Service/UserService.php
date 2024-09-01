<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Infrastructure\Repository\UserRepository;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param string $login
     *
     * @return array
     */
    public function create(string $login): array
    {
        $user = new User();
        $user->setLogin($login);
        $user->setEmail(preg_replace('~\s~', '.', $login) . '@email.dvl.to');
        $user->setFirstName($login . 's First Name');
        $user->setLastName($login . 's Last Name');
        $this->userRepository->create($user);

        return $user->toArray();
    }
}
