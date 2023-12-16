<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\FeeFactory;
use App\Factory\MemberFactory;
use App\Factory\PaymentFactory;
use App\Factory\TeamFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    public function __construct(private PasswordHasherFactoryInterface $passwordHasherFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'admin@membership.co',
            'password' => $this->passwordHasherFactory->getPasswordHasher(User::class)->hash('admin'),
            'roles' => ['ROLE_ADMIN']
        ]);

        FeeFactory::createMany(17);
        TeamFactory::createMany(30);
        MemberFactory::createMany(60);
        PaymentFactory::createMany(10);


        $manager->flush();
    }
}
