<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Infrastructure\Repository;

use App\Application\Pagination\Paginator;
use App\Domain\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductRepository extends ServiceEntityRepository
{
    private CategoryRepository $categoryRepository;

    /**
     * @param ManagerRegistry $registry
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ManagerRegistry $registry, CategoryRepository $categoryRepository)
    {
        parent::__construct($registry, Product::class);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param string $categorySlug
     * @param int $page
     * @return Paginator
     * @throws Exception
     */
    public function findByCategorySlug(string $categorySlug, int $page): Paginator
    {
        $categoryIds  = $this->categoryRepository->findBySlugWithChildren($categorySlug);
        $expression   = $this->getEntityManager()->getExpressionBuilder()->in('category', $categoryIds);
        $queryBuilder = $this->createQueryBuilder('p')
            ->addSelect('d')
            ->innerJoin('p.category', 'category')
            ->leftJoin('p.discount', 'd')
            ->andWhere($expression)
            ->orderBy('p.updatedAt', 'ASC');

        return (new Paginator($queryBuilder))->paginate($page);
    }

    /**
     * @param int $page
     * @param string $tagSlug
     * @return Paginator
     * @throws Exception
     */
    public function findByTag(int $page, string $tagSlug): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->addSelect('d')
            ->leftJoin('p.discount', 'd')
            ->innerJoin('p.tags', 't')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $tagSlug);

        return (new Paginator($queryBuilder))->paginate($page);
    }

}