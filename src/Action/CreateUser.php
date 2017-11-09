<?php

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Faker;
use Slim\Http;
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

    public function __invoke(Http\Request $request, Http\Response $response): Http\Response
    {
        $newRandomUser = new User($this->faker->name, $this->faker->password);

        $this->em->persist($newRandomUser);
        $this->em->flush();

        return $response->withJson($newRandomUser, 201);
    }
}
