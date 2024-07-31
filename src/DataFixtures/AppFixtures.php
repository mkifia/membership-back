<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\AdminFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        AdminFactory::createMany(1);
        $manager->flush();
    }
}
