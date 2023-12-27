<?php

namespace App\Factory;

use App\Entity\Admin;
use App\Entity\User;
use App\Repository\AdminRepository;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Admin>
 *
 * @method        Admin|Proxy                     create(array|callable $attributes = [])
 * @method static Admin|Proxy                     createOne(array $attributes = [])
 * @method static Admin|Proxy                     find(object|array|mixed $criteria)
 * @method static Admin|Proxy                     findOrCreate(array $attributes)
 * @method static Admin|Proxy                     first(string $sortedField = 'id')
 * @method static Admin|Proxy                     last(string $sortedField = 'id')
 * @method static Admin|Proxy                     random(array $attributes = [])
 * @method static Admin|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AdminRepository|RepositoryProxy repository()
 * @method static Admin[]|Proxy[]                 all()
 * @method static Admin[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Admin[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Admin[]|Proxy[]                 findBy(array $attributes)
 * @method static Admin[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Admin[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AdminFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct(private readonly PasswordHasherFactoryInterface $passwordHasherFactory)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'email' => self::faker()->email(),
            'username' => self::faker()->userName(),
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'phone' => self::faker()->phoneNumber(),
            'job' => self::faker()->randomElement([
                'President',
                'Secretary',
                'Treasurer',
                'Advisor',
            ]),
            'bornAt' => self::faker()->dateTimeBetween('-80 years', 'now'),
            'number' => self::faker()->slug(4, false),
            'password' => 'Azerty1234',
            'roles' => ['ROLE_ADMIN', 'ROLE_USER'],
            'salt' => self::faker()->uuid(),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Admin $admin) {
                $admin->setPassword($this->passwordHasherFactory
                    ->getPasswordHasher(Admin::class)->hash($admin->getPassword()));
            });
    }

    protected static function getClass(): string
    {
        return Admin::class;
    }
}
