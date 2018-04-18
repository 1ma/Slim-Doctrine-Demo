<?php

declare(strict_types=1);

namespace UMA\Tests\DoctrineDemo\Unit;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Container;
use UMA\DoctrineDemo\Provider;

class ProvidersTest extends TestCase
{
    public function testContainer(): void
    {
        $sut = new Container(require APP_ROOT . '/settings.php');

        $sut->register(new Provider\Slim())
            ->register(new Provider\Doctrine());

        self::assertInstanceOf(App::class, $sut[App::class]);
        self::assertInstanceOf(EntityManager::class, $sut[EntityManager::class]);
    }
}
