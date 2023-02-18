<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
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
            'roles' => ['ROLE_ADMIN', 'ROLE_MODERATOR'],
            'username' => 'admin',
        ]);

        UserFactory::createOne([
            'email' => 'moderator@example.com',
            'roles' => ['ROLE_MODERATOR'],
            'username' => 'moderator',
        ]);

        UserFactory::createOne([
            'email' => 'user@example.com',
            'username' => 'user',
        ]);

        UserFactory::createMany(8);

        CategoryFactory::createMany(10);

        PostFactory::createMany(30);

        PostFactory::createMany(120, function () {
            return [
                'isApproved' => true
            ];
        });

        CommentFactory::createMany(400);
    }
}
