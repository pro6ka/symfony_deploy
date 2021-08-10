<?php

namespace App\Factory;

use App\Entity\Mpoll;
use App\Repository\MpollRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Mpoll|Proxy createOne(array $attributes = [])
 * @method static Mpoll[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Mpoll|Proxy find($criteria)
 * @method static Mpoll|Proxy findOrCreate(array $attributes)
 * @method static Mpoll|Proxy first(string $sortedField = 'id')
 * @method static Mpoll|Proxy last(string $sortedField = 'id')
 * @method static Mpoll|Proxy random(array $attributes = [])
 * @method static Mpoll|Proxy randomOrCreate(array $attributes = [])
 * @method static Mpoll[]|Proxy[] all()
 * @method static Mpoll[]|Proxy[] findBy(array $attributes)
 * @method static Mpoll[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Mpoll[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static MpollRepository|RepositoryProxy repository()
 * @method Mpoll|Proxy create($attributes = [])
 */
final class MpollFactory extends ModelFactory
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
            'mstatus' => self::faker()->text(),
            'price' => self::faker()->randomFloat(),
            'country' => self::faker()->randomNumber(),
            'lenght' => self::faker()->text(),
            'link' => self::faker()->text(),
            'vendor' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Mpoll $mpoll) {})
        ;
    }

    protected static function getClass(): string
    {
        return Mpoll::class;
    }
}
