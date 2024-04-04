<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Domain;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;
use function password_hash;

// The User class demonstrates how to annotate a simple PHP class to act as a Doctrine entity.

#[Entity, Table(name: 'users')]
final readonly class User implements JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', unique: true, nullable: false, options: ['collation' => 'NOCASE'])]
    private string $email;

    #[Column(name: 'bcrypt_hash', type: 'string', length: 60, nullable: false)]
    private string $hash;

    #[Column(name: 'registered_at', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable $registeredAt;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->hash = password_hash($password, PASSWORD_BCRYPT);
        $this->registeredAt = new DateTimeImmutable('now');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'registered_at' => $this->getRegisteredAt()
                ->format(DateTimeImmutable::ATOM)
        ];
    }
}
