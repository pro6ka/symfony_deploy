<?php

namespace App\Domain\Service;

use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template T
 */

readonly class ModelFactory
{
    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @param class-string|string $modelClass
     * @param ...$parameters
     *
     * @return T
     */
    public function makeModel(string $modelClass, ...$parameters)
    {
        $model = new $modelClass(...$parameters);
        $violations = $this->validator->validate($model);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($parameters, $violations);
        }

        return $model;
    }
}
