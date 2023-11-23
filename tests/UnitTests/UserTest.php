<?php

namespace App\Tests\UnitTests;

use App\Entity\User;
use App\Entity\Dorm;
use App\Entity\History;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testGetId()
    {
        $this->assertNull($this->user->getId());
    }

    public function testEmail()
    {
        $email = 'user@example.com';
        $this->user->setEmail($email);
        $this->assertSame($email, $this->user->getEmail());
        $this->assertSame($email, $this->user->getUserIdentifier());
    }

    public function testRoles()
    {
        $roles = ['ROLE_ADMIN'];
        $this->user->setRoles($roles);
        $this->assertContains(User::USER, $this->user->getRoles());
        $this->assertContains('ROLE_ADMIN', $this->user->getRoles());
    }

    public function testPassword()
    {
        $password = 'password_hash';
        $this->user->setPassword($password);
        $this->assertSame($password, $this->user->getPassword());
    }

    public function testEraseCredentials()
    {
        $user = new User();
        $clonedUser = clone $user;
        $user->eraseCredentials();

        $this->assertEquals($user, $clonedUser);
    }

    public function testAdminDorms()
    {
        $dorm = new Dorm();
        $this->user->addAdminDorm($dorm);
        $this->assertInstanceOf(Collection::class, $this->user->getDorms());
        $this->assertTrue($this->user->getDorms()->contains($dorm));

        $this->user->removeAdminDorm($dorm);
        $this->assertFalse($this->user->getDorms()->contains($dorm));
    }

    public function testDorm()
    {
        $dorm = new Dorm();
        $this->user->setDorm($dorm);
        $this->assertSame($dorm, $this->user->getDorm());
    }

    public function testHistory()
    {
        $history = new History();
        $this->user->addHistory($history);
        $this->assertInstanceOf(Collection::class, $this->user->getHistory());
        $this->assertTrue($this->user->getHistory()->contains($history));
    }
    public function testRemoveHistory()
    {
        $history = new History();
        $this->user->addHistory($history);

        $this->user->removeHistory($history);
        $this->assertFalse($this->user->getHistory()->contains($history));
    }
}
