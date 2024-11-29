<?php

namespace App\Application\Doctrine\Types;

use App\Domain\ValueObject\UserRoleEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\Type;

class UserRoleType extends Type
{
    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param mixed $value The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return null|UserRoleEnum The PHP representation of the value.
     *
     * @throws ValueNotConvertible
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?UserRoleEnum
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            return UserRoleEnum::tryFrom($value);
        }

        throw ValueNotConvertible::new($value, $this->getName());
    }

    /**
     * Converts a value from its PHP representation to its database representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return null|string The database representation of the value.
     *
     * @throws ConversionException
     * @throws ValueNotConvertible
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof UserRoleEnum) {
            return $value->value;
        }

        throw ValueNotConvertible::new($value, $this->getName());
    }

    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'userRole';
    }
}
