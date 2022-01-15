<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Faker;
use Nyholm\Psr7;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UMA\DoctrineDemo\Domain\User;
use function json_encode;

final class CreateUser implements RequestHandlerInterface
{
    private EntityManager $em;
    private Faker\Generator $faker;

    public function __construct(EntityManager $em, Faker\Generator $faker)
    {
        $this->em = $em;
        $this->faker = $faker;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $newRandomUser = new User($this->faker->email(), $this->faker->password());

        $this->em->persist($newRandomUser);
        $this->em->flush();

        $body = Psr7\Stream::create(json_encode($newRandomUser, JSON_PRETTY_PRINT) . PHP_EOL);

        return new Psr7\Response(201, ['Content-Type' => 'application/json'], $body);
    }
}
