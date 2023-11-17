<?php

namespace App\Tests;

use App\Doctrine\CurrentUserExtension;
use App\Entity\Dorm;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
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
        // Create a mock User object and configure it as a non-admin user
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1);
        $this->security->method('getUser')->willReturn($user);
        $this->security->method('isGranted')->with(User::ADMIN)->willReturn(false);

        // Expectations for how the QueryBuilder should be modified
        $this->queryBuilder->expects($this->once())
            ->method('andWhere')
            ->with($this->stringContains('current_user'));
        $this->queryBuilder->expects($this->once())
            ->method('setParameter')
            ->with('current_user', 1);

        // Test the extension with a resource class
        $this->currentUserExtension->applyToCollection($this->queryBuilder, $this->queryNameGenerator, Dorm::class);
    }
}
