<?php

namespace App\Factory;

use App\Entity\Fee;
use App\Repository\FeeRepository;
use JetBrains\PhpStorm\ArrayShape;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Fee>
 *
 * @method        Fee|Proxy                     create(array|callable $attributes = [])
 * @method static Fee|Proxy                     createOne(array $attributes = [])
 * @method static Fee|Proxy                     find(object|array|mixed $criteria)
 * @method static Fee|Proxy                     findOrCreate(array $attributes)
 * @method static Fee|Proxy                     first(string $sortedField = 'id')
 * @method static Fee|Proxy                     last(string $sortedField = 'id')
 * @method static Fee|Proxy                     random(array $attributes = [])
 * @method static Fee|Proxy                     randomOrCreate(array $attributes = [])
 * @method static FeeRepository|RepositoryProxy repository()
 * @method static Fee[]|Proxy[]                 all()
 * @method static Fee[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Fee[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Fee[]|Proxy[]                 findBy(array $attributes)
 * @method static Fee[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Fee[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class FeeFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    #[ArrayShape(['amount' => "float", 'year' => "string"])]
    protected function getDefaults(): array
    {
        return [
            'amount' => self::faker()->randomFloat(2, 0, 50),
            'year' => self::faker()->year(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Fee $fee): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Fee::class;
    }
}
