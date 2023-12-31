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
                 ['year' => 2007, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2008, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2009, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2010, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2011, 'amount' => 25, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2012, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2013, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2014, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2015, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2016, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2017, 'amount' => 0, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2018, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2019, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2020, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2021, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2022, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2023, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                 ['year' => 2024, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
            ];
        });

        AdminFactory::createMany(1);
        $manager->flush();
    }
}
