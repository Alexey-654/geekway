<?php

namespace App\Application\Pagination;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Exception;
use Traversable;

use function count;

final class Paginator
{
    public const ITEMS_ON_PAGE  = 6;
    public const START_PAGE_NUM = 1;

    private QueryBuilder $queryBuilder;
    private int          $currentPage;
    private int                  $pageSize;
    private Traversable          $results;
    private int                  $numResults;

    /**
     * @param QueryBuilder $queryBuilder
     * @param int $pageSize
     */
    public function __construct(QueryBuilder $queryBuilder, int $pageSize = self::ITEMS_ON_PAGE)
    {
        $this->queryBuilder = $queryBuilder;
        $this->pageSize     = $pageSize;
    }

    /**
     * @param int $page
     * @return $this
     * @throws Exception
     */
    public function paginate(int $page = self::START_PAGE_NUM): self
    {
        $this->currentPage = max(self::START_PAGE_NUM, $page);
        $firstResult       = ($this->currentPage - 1) * $this->pageSize;

        $query = $this->queryBuilder->setFirstResult($firstResult)->setMaxResults($this->pageSize)->getQuery();

        if (count($this->queryBuilder->getDQLPart('join')) === 0) {
            $query->setHint(CountWalker::HINT_DISTINCT, false);
        }

        $paginator = new DoctrinePaginator($query, true);

        $useOutputWalkers = count($this->queryBuilder->getDQLPart('having') ?: []) > 0;
        $paginator->setUseOutputWalkers($useOutputWalkers);

        $this->results    = $paginator->getIterator();
        $this->numResults = $paginator->count();

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getLastPage(): int
    {
        return (int)ceil($this->numResults / $this->pageSize);
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return bool
     */
    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    /**
     * @return int
     */
    public function getPreviousPage(): int
    {
        return max(1, $this->currentPage - 1);
    }

    /**
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getLastPage();
    }

    /**
     * @return int
     */
    public function getNextPage(): int
    {
        return min($this->getLastPage(), $this->currentPage + 1);
    }

    /**
     * @return bool
     */
    public function hasToPaginate(): bool
    {
        return $this->numResults > $this->pageSize;
    }

    /**
     * @return int
     */
    public function getNumResults(): int
    {
        return $this->numResults;
    }

    /**
     * @return Traversable
     */
    public function getResults(): Traversable
    {
        return $this->results;
    }
}