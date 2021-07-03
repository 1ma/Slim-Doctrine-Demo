<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\DI;

use Doctrine\ORM\EntityManager;
use Faker;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use UMA\DIC\Container;
use UMA\DIC\ServiceProvider;
use UMA\DoctrineDemo\Action\CreateUser;
use UMA\DoctrineDemo\Action\ListUsers;

/**
 * A ServiceProvider for registering services related
 * to Slim such as request handlers, routing and the
 * App service itself that wires everything together.
 */
class Slim implements ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function provide(Container $c): void
    {
        $c->set(Faker\Generator::class, static function(): Faker\Generator {
            return Faker\Factory::create();
        });

        $c->set(ListUsers::class, static function(Container $c): RequestHandlerInterface {
            return new ListUsers(
                $c->get(EntityManager::class)
            );
        });

        $c->set(CreateUser::class, static function(Container $c): RequestHandlerInterface {
            return new CreateUser(
                $c->get(EntityManager::class),
                $c->get(Faker\Generator::class)
            );
        });

        $c->set(App::class, static function (Container $c): App {
            /** @var array $settings */
            $settings = $c->get('settings');

            $app = AppFactory::create(null, $c);

            $app->addErrorMiddleware(
                $settings['slim']['displayErrorDetails'],
                $settings['slim']['logErrors'],
                $settings['slim']['logErrorDetails']
            );

            $app->get('/users', ListUsers::class);
            $app->post('/users', CreateUser::class);

            return $app;
        });
    }
}
