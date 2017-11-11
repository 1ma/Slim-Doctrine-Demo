<?php

namespace UMA\Tests\DoctrineDemo\Functional;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Environment;
use UMA\Tests\DoctrineDemo\FunctionalTestCase;

class AppTest extends FunctionalTestCase
{
    public function testCreatingAUserWithThePostEndpoint()
    {
        $response = $this->runApp(new Environment([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => '/users'
        ]));

        self::assertSame(201, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testGettingAListOfUsersWithTheGetEndpoint(): ResponseInterface
    {
        $response = $this->runApp(new Environment([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/users'
        ]));

        self::assertSame(200, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));

        return $response;
    }

    public function testSeveralApiCalls()
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
}
