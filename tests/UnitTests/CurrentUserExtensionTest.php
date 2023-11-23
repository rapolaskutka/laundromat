<?php

namespace App\Tests\UnitTests;

use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Doctrine\CurrentUserExtension;
use App\Entity\Dorm;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;

class CurrentUserExtensionTest extends TestCase
{
    private $security;
    private $currentUserExtension;
    private $queryBuilder;
    private $queryNameGenerator;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->currentUserExtension = new CurrentUserExtension($this->security);

        $this->queryBuilder = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryNameGenerator = $this->createMock(QueryNameGeneratorInterface::class);

        // Configure the QueryBuilder mock to return itself
        $this->queryBuilder->method('getRootAliases')->willReturn(['o']);
        $this->queryBuilder->method('andWhere')->willReturnSelf();
        $this->queryBuilder->method('setParameter')->willReturnSelf();
    }

    public function testApplyToCollectionForStandardUser(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1);
        $this->security->method('getUser')->willReturn($user);
        $this->security->method('isGranted')->with(User::ADMIN)->willReturn(false);

        $this->queryBuilder->expects($this->once())
            ->method('andWhere')
            ->with($this->stringContains('current_user'));
        $this->queryBuilder->expects($this->once())
            ->method('setParameter')
            ->with('current_user', 1);

        $this->currentUserExtension->applyToCollection($this->queryBuilder, $this->queryNameGenerator, Dorm::class);
    }
    public function testApplyToCollectionForAdminUser(): void
    {
        // Create a mock User object and configure it as a non-admin user
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1);
        $this->security->method('getUser')->willReturn($user);
        $this->security->method('isGranted')->with(User::ADMIN)->willReturn(true);

        $this->queryBuilder->expects($this->never())
            ->method('andWhere')
            ->with($this->stringContains('current_user'));
        $this->queryBuilder->expects($this->never())
            ->method('setParameter')
            ->with('current_user', 1);

        $this->currentUserExtension->applyToCollection($this->queryBuilder, $this->queryNameGenerator, Dorm::class);
    }
}
