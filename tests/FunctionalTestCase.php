<?php

namespace UMA\Tests\DoctrineDemo;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http;

class FunctionalTestCase extends TestCase
{
    /**
     * @var App
     */
    protected static $app;

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

    /**
     * Load the schema into the in-memory database before every test
     */
    protected function setUp()
    {
        self::$tool->createSchema(self::$schema);
    }

    /**
     * Drop the whole schema from the in-memory database after every test
     */
    protected function tearDown()
    {
        self::$tool->dropSchema(self::$schema);
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
