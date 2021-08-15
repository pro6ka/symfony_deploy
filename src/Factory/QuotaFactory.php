<?php

namespace App\Factory;

use App\Entity\Quota;
use App\Repository\QuotaRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Quota|Proxy createOne(array $attributes = [])
 * @method static Quota[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Quota|Proxy find($criteria)
 * @method static Quota|Proxy findOrCreate(array $attributes)
 * @method static Quota|Proxy first(string $sortedField = 'id')
 * @method static Quota|Proxy last(string $sortedField = 'id')
 * @method static Quota|Proxy random(array $attributes = [])
 * @method static Quota|Proxy randomOrCreate(array $attributes = [])
 * @method static Quota[]|Proxy[] all()
 * @method static Quota[]|Proxy[] findBy(array $attributes)
 * @method static Quota[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Quota[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static QuotaRepository|RepositoryProxy repository()
 * @method Quota|Proxy create($attributes = [])
 */
final class QuotaFactory extends ModelFactory
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
            'name' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Quota $quota) {})
        ;
    }

    protected static function getClass(): string
    {
        return Quota::class;
    }
}
