<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'admin@example.com',
            'roles' => ['ROLE_ADMIN'],
            'username' => 'admin',
        ]);

        UserFactory::createOne([
            'email' => 'user@example.com',
            'username' => 'user',
        ]);

        UserFactory::createMany(8);

        CategoryFactory::createMany(10);

        PostFactory::createMany(100);
    }
}
