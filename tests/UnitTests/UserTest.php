<?php

namespace App\Tests\unitTests;

use App\Entity\Dorm;
use App\Entity\History;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetSetEmail()
    {
        $email = 'test@example.com';
        $user = new User();
        $user->setEmail($email);

        $this->assertEquals($email, $user->getEmail());
    }
    public function testEraseCredentials()
    {
        $user = new User();
        $clonedUser = clone $user;
        $user->eraseCredentials();

        $this->assertEquals($user, $clonedUser);
    }

    public function testGetSetRoles()
    {
        $roles = ['ROLE_USER'];
        $user = new User();
        $user->setRoles($roles);

        $this->assertEquals($roles, $user->getRoles());
    }

    public function testGetSetPassword()
    {
        $password = 'password';
        $user = new User();
        $user->setPassword($password);

        $this->assertEquals($password, $user->getPassword());
    }

    public function testAddDorm()
    {
        $user = new User();
        $dorm = new Dorm();

        $user->addAdminDorm($dorm);
        $this->assertContains($dorm, $user->getDorms());
    }

    public function testRemoveDorm()
    {
        $user = new User();
        $dorm = new Dorm();

        $user->removeAdminDorm($dorm);
        $this->assertNotContains($dorm, $user->getDorms());
    }

    public function testGetSetDorm()
    {
        $user = new User();
        $dorm = new Dorm();

        $user->setDorm($dorm);
        $this->assertSame($dorm, $user->getDorm());
    }

    public function testAddHistory()
    {
        $user = new User();
        $history = new History();

        $user->addHistory($history);
        $this->assertContains($history, $user->getHistory());
    }

    public function testRemoveHistory()
    {
        $user = new User();
        $history = new History();

        $user->removeHistory($history);
        $this->assertNotContains($history, $user->getHistory());
    }

    public function testGetUserIdentifier()
    {
        $user = new User();
        $user->setEmail('test@test.ktu');
        $this->assertSame($user->getEmail(), $user->getUserIdentifier());
    }
}
