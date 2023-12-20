<?php

namespace App\DataFixtures;

use App\Factory\AddressFactory;
use App\Factory\AdminFactory;
use App\Factory\FeeFactory;
use App\Factory\MemberFactory;
use App\Factory\PaymentFactory;
use App\Factory\TeamFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        FeeFactory::createMany(10);
        $addresses = AddressFactory::createMany(10);
        TeamFactory::createMany(10, function () use ($addresses) {
            return [
                'members' => MemberFactory::createMany(5, function () use ($addresses) {
                    return [
                        'address' => $addresses[array_rand($addresses)],
                        'payments' => PaymentFactory::createMany(10),
                    ];
                }),
            ];
        });
        AdminFactory::createMany(5, function () use ($addresses) {
            return [
                'address' => $addresses[array_rand($addresses)],
            ];
        });
        $manager->flush();
    }
}
