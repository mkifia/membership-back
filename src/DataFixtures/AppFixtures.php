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
        FeeFactory::createSequence(function () {
            return [
                 ['year' => 2007, 'amount' => 50],
                 ['year' => 2008, 'amount' => 50],
                 ['year' => 2009, 'amount' => 50],
                 ['year' => 2010, 'amount' => 50],
                 ['year' => 2011, 'amount' => 50],
                 ['year' => 2012, 'amount' => 50],
                 ['year' => 2013, 'amount' => 50],
                 ['year' => 2014, 'amount' => 25],
                 ['year' => 2015, 'amount' => 50],
                 ['year' => 2016, 'amount' => 50],
                 ['year' => 2017, 'amount' => 0],
                 ['year' => 2018, 'amount' => 50],
                 ['year' => 2019, 'amount' => 50],
                 ['year' => 2020, 'amount' => 50],
                 ['year' => 2021, 'amount' => 50],
                 ['year' => 2022, 'amount' => 50],
                 ['year' => 2023, 'amount' => 50],
                 ['year' => 2024, 'amount' => 50],
            ];
        });

        AdminFactory::createMany(1);
        $manager->flush();
    }
}
