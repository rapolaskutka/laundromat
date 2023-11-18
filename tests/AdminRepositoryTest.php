<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class AdminRepositoryTest extends TestCase
{
    private $entityManagerMock;
    private $classMetadataMock;
    private $managerRegistryMock;
    private $adminRepository;

    protected function setUp(): void
    {
        // Mock the ClassMetadata
        $this->classMetadataMock = $this->createMock(ClassMetadata::class);

        // Mock the EntityManager to return ClassMetadata mock
        $this->entityManagerMock = $this->createMock(EntityManager::class);
        $this->entityManagerMock->method('getClassMetadata')->willReturn($this->classMetadataMock);

        // Mock the ManagerRegistry to return the EntityManager mock
        $this->managerRegistryMock = $this->createMock(ManagerRegistry::class);
        $this->managerRegistryMock->method('getManagerForClass')->willReturn($this->entityManagerMock);

        $this->adminRepository = new AdminRepository($this->managerRegistryMock, User::class);
    }

    public function testUpgradePasswordWithUser(): void
    {
        $user = $this->createMock(User::class);
        $newHashedPassword = 'new_hashed_password';

        // Expectations for the user object
        $user->expects($this->once())
            ->method('setPassword')
            ->with($this->equalTo($newHashedPassword));

        // Expect the EntityManager to persist and flush the user
        $this->entityManagerMock->expects($this->once())->method('persist')->with($user);
        $this->entityManagerMock->expects($this->once())->method('flush');

        // Execute the method
        $this->adminRepository->upgradePassword($user, $newHashedPassword);
    }

    public function testUpgradePasswordWithUnsupportedUser(): void
    {
        $this->expectException(UnsupportedUserException::class);

        $unsupportedUser = $this->createMock(PasswordAuthenticatedUserInterface::class);
        $newHashedPassword = 'new_hashed_password';

        // Execute the method with an unsupported user type
        $this->adminRepository->upgradePassword($unsupportedUser, $newHashedPassword);
    }
}
