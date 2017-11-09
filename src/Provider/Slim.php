<?php

declare (strict_types=1);

namespace UMA\DoctrineDemo\Provider;

use Doctrine\ORM\EntityManager;
use Faker;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;
use UMA\DoctrineDemo\Action\CreateUser;
use UMA\DoctrineDemo\Action\ListUsers;

class Slim implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $cnt)
    {
        $cnt[ListUsers::class] = function (Container $cnt): ListUsers {
            return new ListUsers($cnt[EntityManager::class]);
        };

        $cnt[CreateUser::class] = function (Container $cnt): CreateUser {
            return new CreateUser(
                $cnt[EntityManager::class],
                Faker\Factory::create()
            );
        };

        $cnt[App::class] = function (Container $cnt): App {
            $app = new App($cnt);

            $app->get('/users', ListUsers::class);
            $app->post('/users', CreateUser::class);

            return $app;
        };
    }
}
