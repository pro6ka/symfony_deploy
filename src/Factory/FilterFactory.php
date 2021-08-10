<?php

namespace App\Factory;

use App\Entity\Filter;
use App\Repository\FilterRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Filter|Proxy createOne(array $attributes = [])
 * @method static Filter[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Filter|Proxy find($criteria)
 * @method static Filter|Proxy findOrCreate(array $attributes)
 * @method static Filter|Proxy first(string $sortedField = 'id')
 * @method static Filter|Proxy last(string $sortedField = 'id')
 * @method static Filter|Proxy random(array $attributes = [])
 * @method static Filter|Proxy randomOrCreate(array $attributes = [])
 * @method static Filter[]|Proxy[] all()
 * @method static Filter[]|Proxy[] findBy(array $attributes)
 * @method static Filter[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Filter[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FilterRepository|RepositoryProxy repository()
 * @method Filter|Proxy create($attributes = [])
 */
final class FilterFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
            'filterType' => self::faker()->text(),
            'name' => self::faker()->text(),
            'value' => self::faker()->text(),
            'description' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Filter $filter) {})
        ;
    }

    protected static function getClass(): string
    {
        return Filter::class;
    }
}
