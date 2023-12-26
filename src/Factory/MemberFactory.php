<?php

namespace App\Factory;

use App\Entity\Member;
use App\Repository\MemberRepository;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Member>
 *
 * @method        Member|Proxy                     create(array|callable $attributes = [])
 * @method static Member|Proxy                     createOne(array $attributes = [])
 * @method static Member|Proxy                     find(object|array|mixed $criteria)
 * @method static Member|Proxy                     findOrCreate(array $attributes)
 * @method static Member|Proxy                     first(string $sortedField = 'id')
 * @method static Member|Proxy                     last(string $sortedField = 'id')
 * @method static Member|Proxy                     random(array $attributes = [])
 * @method static Member|Proxy                     randomOrCreate(array $attributes = [])
 * @method static MemberRepository|RepositoryProxy repository()
 * @method static Member[]|Proxy[]                 all()
 * @method static Member[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Member[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Member[]|Proxy[]                 findBy(array $attributes)
 * @method static Member[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Member[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class MemberFactory extends ModelFactory
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
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'bornAt' => self::faker()->dateTimeBetween('-80 years', 'now'),
            'createdAt' => new \DateTimeImmutable(),
            'email' => self::faker()->email(),
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'number' => self::faker()->slug(4, false),
            'password' => 'Azerty1234!',
            'phone' => self::faker()->phoneNumber(),
            'roles' => ['ROLE_USER'],
            'salt' => self::faker()->uuid(),
            'status' => self::faker()->randomElement(['suspended', 'active', 'overdue', 'deleted']),
            'updatedAt' => new \DateTimeImmutable(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Member $member) {
                $member->setPassword($this->passwordHasherFactory
                    ->getPasswordHasher(Member::class)->hash($member->getPassword()));
            });
    }

    protected static function getClass(): string
    {
        return Member::class;
    }
}
