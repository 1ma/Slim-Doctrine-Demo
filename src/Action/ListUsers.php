<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Action;

use Doctrine\ORM\EntityManager;
use Nyholm\Psr7\Stream;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UMA\DoctrineDemo\Domain\User;
use function json_encode;

class ListUsers implements RequestHandlerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(EntityManager $em, ResponseFactoryInterface $responseFactory)
    {
        $this->em = $em;
        $this->responseFactory = $responseFactory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var User[] $users */
        $users = $this->em
            ->getRepository(User::class)
            ->findAll();

        $body = Stream::create(json_encode($users));

        return $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', $body->getSize())
            ->withBody($body);
    }
}
