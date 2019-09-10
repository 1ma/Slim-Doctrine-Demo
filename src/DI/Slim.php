<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\DI;

use Doctrine\ORM\EntityManager;
use Faker;
use Slim\App;
use Slim\Factory\AppFactory;
use UMA\DIC\Container;
use UMA\DIC\ServiceProvider;
use UMA\DoctrineDemo\Action\CreateUser;
use UMA\DoctrineDemo\Action\ListUsers;

/**
 * A ServiceProvider for registering services related
 * to Slim such as request handlers, routing and the
 * App service itself.
 */
class Slim implements ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function provide(Container $c): void
    {
        $c->set(ListUsers::class, static function(Container $c): ListUsers {
            return new ListUsers(
                $c->get(EntityManager::class)
            );
        });

        $c->set(CreateUser::class, static function(Container $c): CreateUser {
            return new CreateUser(
                $c->get(EntityManager::class),
                Faker\Factory::create()
            );
        });

        $c->set(App::class, static function (Container $c): App {
            $app = AppFactory::create(null, $c);

            $app->get('/users', ListUsers::class);
            $app->post('/users', CreateUser::class);

            return $app;
        });
    }
}
