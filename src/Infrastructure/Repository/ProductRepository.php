<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Infrastructure\Repository;

use App\Application\Pagination\Paginator;
use App\Domain\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByCategory(int $page = 1, ?string $categorySlug = null): Paginator
    {
        $qb = $this->createQueryBuilder('p');
        if ($categorySlug !== null) {
            $qb->addSelect('c')
                ->innerJoin('p.category', 'c')
                ->where('c.slug = :slug')
                ->setParameter('slug', $categorySlug);
        }
        $qb->orderBy('p.updatedAt', 'ASC');

        return (new Paginator($qb))->paginate($page);
    }

    public function findByTag(int $page = 1, string $tagSlug = null): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('t')
            ->innerJoin('p.tags', 't')
            ->where('t.slug = :slug')
            ->setParameter('slug', $tagSlug);

        return (new Paginator($qb))->paginate($page);
    }

}