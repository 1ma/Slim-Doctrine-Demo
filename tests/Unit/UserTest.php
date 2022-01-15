<?php

declare(strict_types=1);

namespace UMA\Tests\DoctrineDemo\Unit;

use PHPUnit\Framework\TestCase;
use UMA\DoctrineDemo\Domain\User;
use function password_verify;

final class UserTest extends TestCase
{
    public function testPasswordIsHashedWithBcrypt(): void
    {
        $sut = new User('john.doe@example.com', $plainPwd = 'abcd');

        self::assertTrue(password_verify($plainPwd, $sut->getHash()));
    }
}
