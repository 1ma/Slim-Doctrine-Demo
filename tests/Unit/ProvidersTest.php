<?php

declare(strict_types=1);

namespace UMA\Tests\DoctrineDemo\Unit;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Slim\App;
use UMA\DIC\Container;
use UMA\DoctrineDemo\DI;

final class ProvidersTest extends TestCase
{
    public function testContainer(): void
    {
        $sut = new Container($GLOBALS['testingSettings']);

        $sut->register(new DI\Slim());
        $sut->register(new DI\Doctrine());

        self::assertInstanceOf(App::class, $sut->get(App::class));
        self::assertInstanceOf(EntityManager::class, $sut->get(EntityManager::class));
    }
}
