<?php

declare(strict_types=1);

namespace UMA\Tests\DoctrineDemo\Functional;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http;

class EndToEndTest extends TestCase
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

    public function testCreatingAUserWithThePostEndpoint(): void
    {
        $response = $this->runApp(new Http\Environment([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => '/users'
        ]));

        self::assertSame(201, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testGettingAListOfUsersWithTheGetEndpoint(): ResponseInterface
    {
        $response = $this->runApp(new Http\Environment([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/users'
        ]));

        self::assertSame(200, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));

        return $response;
    }

    public function testSeveralApiCalls(): void
    {
        $users = json_decode((string) $this->testGettingAListOfUsersWithTheGetEndpoint()->getBody());
        self::assertCount(0, $users);

        $this->testCreatingAUserWithThePostEndpoint();
        $this->testCreatingAUserWithThePostEndpoint();
        $this->testCreatingAUserWithThePostEndpoint();

        $users = json_decode((string) $this->testGettingAListOfUsersWithTheGetEndpoint()->getBody());
        self::assertCount(3, $users);

        $this->testCreatingAUserWithThePostEndpoint();

        $users = json_decode((string) $this->testGettingAListOfUsersWithTheGetEndpoint()->getBody());
        self::assertCount(4, $users);
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
