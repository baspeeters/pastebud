<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function test__construct()
    {
        // Given that I have a user
        $user = new User();

        // Its username should be null
        self::assertNull($user->getUsername());

        // ... and its e-mail address should be null
        self::assertNull($user->getEmail());

        // ... and its plain password should be null
        self::assertNull($user->getPlainPassword());

        // ... and its password should be null
        self::assertNull($user->getPassword());

        // .. and its should only have the user role
        self::assertEquals(['ROLE_USER'], $user->getRoles());
    }

    /** @test */
    public function SetAndGetUsername()
    {
        // Given that I have a user
        $user = new User();

        // Then when I set the username
        self::assertNull($user->setUsername('crash-override'));

        // It should have updated the username
        self::assertEquals('crash-override', $user->getUsername());
    }

    /** @test */
    public function SetAndGetEmail()
    {
        // Given that I have a user
        $user = new User();

        // Then when I set the e-mail address
        $user->setEmail('foo@bar.baz');

        // It should have updated the e-mail address
        self::assertEquals('foo@bar.baz', $user->getEmail());
    }

    /** @test */
    public function SetAndGetPlainPassword()
    {
        // Given that I have a user
        $user = new User();

        // Then when I set the plain password
        $user->setPlainPassword('test123');

        // It should have updated the plain password
        self::assertEquals('test123', $user->getPlainPassword());
    }

    /** @test */
    public function SetAndGetPassword()
    {
        // Given that I have a user
        $user = new User();

        // Then when I set the password
        $user->setPassword('hashed');

        // It should have updated the password
        self::assertEquals('hashed', $user->getPassword());

        // ... and it should have cleared the plain password
        self::assertNull($user->getPlainPassword());
    }

    /** @test */
    public function EraseCredentials()
    {
        // Given that I have a user
        $user = new User();

        // And its e-mail address and password are set
        $user->setEmail('bar@baz.foo');
        $user->setPassword('hash-hash');

        // ... and its plain password is set
        $user->setPlainPassword('plain-plain');

        // Then when the credentials are erased
        $user->eraseCredentials();

        // Its plain password should be null
        self::assertNull($user->getPlainPassword());
    }

    /** @test */
    public function SerializeAndUnserialize()
    {
        // Given that I have a user
        $user = new User();

        // And its username and password are set
        $user->setUsername('zero-cool');
        $user->setPassword('this-is-hashed');

        // Then when serialize is called
        $serialized = $user->serialize();

        // It should return a serialized string of the user
        self::assertEquals('a:3:{i:0;N;i:1;s:9:"zero-cool";i:2;s:14:"this-is-hashed";}', $serialized);

        // ... and it should correspond to its id, username and password when unserialized
        $user->unserialize($serialized);

        $unserialized = $user->getData();
        self::assertInternalType('array', $unserialized);
        self::assertEquals([null, 'zero-cool', 'this-is-hashed'], $unserialized);
    }

    /** @test */
    public function GetSalt()
    {
        // Given that I have a user
        $user = new User();

        self::assertNull($user->getSalt());
    }
}
