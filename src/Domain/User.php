<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, nullable=false)
     */
    private $hash;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable", nullable=false)
     */
    private $registeredAt;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->hash = password_hash($password, PASSWORD_BCRYPT);
        $this->registeredAt = new \DateTimeImmutable('now');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getRegisteredAt(): \DateTimeImmutable
    {
        return $this->registeredAt;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'registered_at' => $this->getRegisteredAt()
                ->format(\DateTime::ATOM)
        ];
    }
}
