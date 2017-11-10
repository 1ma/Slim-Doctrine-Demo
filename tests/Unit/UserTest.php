<?php

declare(strict_types=1);

namespace UMA\Tests\DoctrineDemo\Unit;

use PHPUnit\Framework\TestCase;
use UMA\DoctrineDemo\Domain\User;

class UserTest extends TestCase
{
    public function testPasswordIsHashedWithBcrypt()
    {
        $user = new User('john.doe@example.com', $plainPwd = 'abcd');

        self::assertTrue(password_verify($plainPwd, $user->getHash()));
    }
}
