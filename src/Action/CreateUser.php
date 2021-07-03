<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Faker;
use Nyholm\Psr7\Stream;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UMA\DoctrineDemo\Domain\User;
use function json_encode;

class CreateUser implements RequestHandlerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Faker\Generator
     */
    private $faker;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(EntityManager $em, Faker\Generator $faker, ResponseFactoryInterface $responseFactory)
    {
        $this->em = $em;
        $this->faker = $faker;
        $this->responseFactory = $responseFactory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $newRandomUser = new User($this->faker->name, $this->faker->password);

        $this->em->persist($newRandomUser);
        $this->em->flush();

        $body = Stream::create(json_encode($newRandomUser));

        return $this->responseFactory->createResponse(201)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', $body->getSize())
            ->withBody($body);
    }
}
