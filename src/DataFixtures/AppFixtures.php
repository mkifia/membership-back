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
        $teams = TeamFactory::createMany(10);
        $payments = PaymentFactory::createMany(10);
        AdminFactory::createMany(5, function () use ($addresses, $teams) {
            return [
                'address' => $addresses[array_rand($addresses)],
            ];
        });
        MemberFactory::createMany(5, function () use ($teams, $addresses, $payments) {
            return [
                'team' => $teams[array_rand($teams)],
                'address' => $addresses[array_rand($addresses)],
                'payments' => $payments,
            ];
        });

        $manager->flush();
    }
}
