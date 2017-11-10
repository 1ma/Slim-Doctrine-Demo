<?php

namespace UMA\Tests\DoctrineDemo\Functional;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Environment;
use UMA\Tests\DoctrineDemo\FunctionalTestCase;

class AppTest extends FunctionalTestCase
{
    public function testPostUser()
    {
        $response = $this->runApp(new Environment([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => '/users'
        ]));

        self::assertSame(201, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testGetUsers(): ResponseInterface
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

    public function testAppWorkflow()
    {
        $users = json_decode((string) $this->testGetUsers()->getBody());

        self::assertCount(0, $users);

        $this->testPostUser();
        $this->testPostUser();
        $this->testPostUser();

        $users = json_decode((string) $this->testGetUsers()->getBody());

        self::assertCount(3, $users);
    }
}
