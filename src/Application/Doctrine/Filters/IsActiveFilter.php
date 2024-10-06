<?php

namespace App\Application\Doctrine\Filters;

use App\Domain\Entity\Contracts\ActivatedInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class IsActiveFilter extends SQLFilter
{
    /**
     * Gets the SQL query part to add to a query.
     *
     * @psalm-param ClassMetadata<object> $targetEntity
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, string $targetTableAlias): string
    {
        if (! $targetEntity->reflClass->implementsInterface(ActivatedInterface::class)) {
            return '';
        }

        return $this->getParameter('checkIsActive')
            ? '(' . $targetTableAlias . '.is_active=true' . ')'
            : '';
    }
}
