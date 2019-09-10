<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Faker;
use Nyholm\Psr7;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use UMA\DoctrineDemo\Domain\User;

class CreateUser
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function __construct(EntityManager $em, Faker\Generator $faker)
    {
        $this->em = $em;
        $this->faker = $faker;
    }

    public function __invoke(Psr7\ServerRequest $request, Psr7\Response $response): Psr7\Response
    {
        $newRandomUser = new User($this->faker->name, $this->faker->password);

        $this->em->persist($newRandomUser);
        $this->em->flush();

        $body = Psr7\Stream::create(\json_encode($newRandomUser));

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', $body->getSize())
            ->withBody($body);
    }
}
