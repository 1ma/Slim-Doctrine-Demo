<?php

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Slim\Http;
use UMA\DoctrineDemo\Domain\User;

class ListUsers
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __invoke(Http\Request $request, Http\Response $response): Http\Response
    {
        /** @var User[] $users */
        $users = $this->em
            ->getRepository(User::class)
            ->findAll();

        return $response->withJson($users, 200);
    }
}
