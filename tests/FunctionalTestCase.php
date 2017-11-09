<?php

namespace UMA\Tests\DoctrineDemo;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Slim\Container;

class FunctionalTestCase extends TestCase
{
    /**
     * @var Container
     */
    protected static $container;

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
        self::$container = $GLOBALS['cnt'];
        self::$tool = new SchemaTool(self::$container[EntityManager::class]);
        self::$schema = self::$container[EntityManager::class]
            ->getMetadataFactory()
            ->getAllMetadata();
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

}
