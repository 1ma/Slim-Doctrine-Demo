<?php

namespace UMA\Tests\DoctrineDemo;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http;

/**
 * An specialized TestCase for functional testing.
 *
 * Test cases extending this one will have a fresh
 * in-memory database at the beginning of every test.
 *
 * It also provides a helper method to run the whole
 * Slim application from a mocked Environment.
 */
abstract class FunctionalTestCase extends TestCase
{
    /**
     * @var App
     */
    private static $app;

    /**
     * @var SchemaTool
     */
    private static $tool;

    /**
     * @var ClassMetadata[]
     */
    private static $schema;

    public static function setUpBeforeClass()
    {
        self::$app = $GLOBALS['cnt'][App::class];

        /** @var EntityManager $em */
        $em = self::$app->getContainer()[EntityManager::class];
        self::$schema = $em->getMetadataFactory()->getAllMetadata();
        self::$tool = new SchemaTool($em);
    }

    protected function setUp()
    {
        self::$tool->dropSchema(self::$schema);
        self::$tool->createSchema(self::$schema);
    }

    protected function runApp(Http\Environment $environment): Http\Response
    {
        /** @var Http\Response $response */
        $response = self::$app->process(
            Http\Request::createFromEnvironment($environment),
            new Http\Response()
        );

        return $response;
    }
}
