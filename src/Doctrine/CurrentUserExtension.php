<?php
// api/src/Doctrine/CurrentUserExtension.php
namespace App\Doctrine;
use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Dorm;
use App\Entity\History;
use App\Entity\Machine;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Config\Definition\Exception\Exception;

final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(private readonly Security $security)
    {
    }
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        /* @var User $user */
        if ($this->security->isGranted(User::ADMIN) || !$user = $this->security->getUser()) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];

        if (Machine::class === $resourceClass && $dorm_id = $user->getDorm()?->getId()) {
            $queryBuilder->andWhere(sprintf('%s.dorm = :dorm_id', $rootAlias));
            $queryBuilder->setParameter('dorm_id', $dorm_id);
        } else {
            $queryBuilder = match ($resourceClass) {
                Dorm::class => $queryBuilder->andWhere(sprintf('%s.administrator = :current_user', $rootAlias)),
                History::class => $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias)),
                User::class => $queryBuilder->andWhere(sprintf('%s.id = :current_user', $rootAlias)),
                default => $queryBuilder,
            };
            $queryBuilder->setParameter('current_user', $user->getId());
        }
    }
}
