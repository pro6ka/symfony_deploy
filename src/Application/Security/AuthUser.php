<?php

namespace App\Application\Security;

use Symfony\Component\Security\Core\User\UserInterface;

readonly class AuthUser implements UserInterface
{
    private string $username;

    /** @var array|string[] */
    private array $roles;

    /**
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->username = $credentials['username'];
        $this->roles = array_unique(array_merge($credentials['roles'] ?? [], ['ROLE_USER']));
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored in a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }
}
