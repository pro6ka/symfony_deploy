<?php

namespace App\Factory;

use App\Entity\QuotaDetail;
use App\Repository\QuotaDetailRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static QuotaDetail|Proxy createOne(array $attributes = [])
 * @method static QuotaDetail[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static QuotaDetail|Proxy find($criteria)
 * @method static QuotaDetail|Proxy findOrCreate(array $attributes)
 * @method static QuotaDetail|Proxy first(string $sortedField = 'id')
 * @method static QuotaDetail|Proxy last(string $sortedField = 'id')
 * @method static QuotaDetail|Proxy random(array $attributes = [])
 * @method static QuotaDetail|Proxy randomOrCreate(array $attributes = [])
 * @method static QuotaDetail[]|Proxy[] all()
 * @method static QuotaDetail[]|Proxy[] findBy(array $attributes)
 * @method static QuotaDetail[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static QuotaDetail[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static QuotaDetailRepository|RepositoryProxy repository()
 * @method QuotaDetail|Proxy create($attributes = [])
 */
final class QuotaDetailFactory extends ModelFactory
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
            'sendOrder' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(QuotaDetail $quotaDetail) {})
        ;
    }

    protected static function getClass(): string
    {
        return QuotaDetail::class;
    }
}
