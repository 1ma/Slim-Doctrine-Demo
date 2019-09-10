<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Nyholm\Psr7;
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

    public function __invoke(Psr7\ServerRequest $request, Psr7\Response $response): Psr7\Response
    {
        /** @var User[] $users */
        $users = $this->em
            ->getRepository(User::class)
            ->findAll();

        $body = Psr7\Stream::create(\json_encode($users));

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', $body->getSize())
            ->withBody($body);
    }
}
