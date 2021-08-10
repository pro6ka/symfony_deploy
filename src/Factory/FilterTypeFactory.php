<?php

namespace App\Factory;

use App\Entity\FilterType;
use App\Repository\FilterTypeRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use function rand;

/**
 * @method static FilterType|Proxy createOne(array $attributes = [])
 * @method static FilterType[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static FilterType|Proxy find($criteria)
 * @method static FilterType|Proxy findOrCreate(array $attributes)
 * @method static FilterType|Proxy first(string $sortedField = 'id')
 * @method static FilterType|Proxy last(string $sortedField = 'id')
 * @method static FilterType|Proxy random(array $attributes = [])
 * @method static FilterType|Proxy randomOrCreate(array $attributes = [])
 * @method static FilterType[]|Proxy[] all()
 * @method static FilterType[]|Proxy[] findBy(array $attributes)
 * @method static FilterType[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static FilterType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FilterTypeRepository|RepositoryProxy repository()
 * @method FilterType|Proxy create($attributes = [])
 */
final class FilterTypeFactory extends ModelFactory
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
            'id' => rand(1000, 10000),
            'name' => self::faker()->text(40),
            'description' => self::faker()->text(255),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(FilterType $filterType) {})
        ;
    }

    protected static function getClass(): string
    {
        return FilterType::class;
    }
}
