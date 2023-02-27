<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Find category id with children category ids
     * @param string $slug
     * @return int[]
     */
    public function findBySlugWithChildren(string $slug): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Category::class, 'u');
        $rsm->addFieldResult('u', 'id', 'id');
        $sql = <<<SQL
            WITH RECURSIVE cte AS(
                select id from category where slug = :slug
                UNION
                select c.id from category c
                inner join cte on cte.id = c.parent_id
            ) SELECT * FROM cte
            SQL;

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter('slug', $slug);

        return $query->getSingleColumnResult();
    }
}