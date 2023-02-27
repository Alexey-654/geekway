<?php

namespace App\Infrastructure\Controller;

use App\Domain\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogController extends AbstractController
{
    private ManagerRegistry $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param string $slug
     * @param int $page
     * @param string $_route
     * @return Response
     */
    #[Route('/catalog/{slug}/{page}', name: 'catalog_category_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function showByCategory(string $slug, int $page, string $_route): Response
    {
        $products = $this->doctrine->getRepository(Product::class)->findByCategorySlug($slug, $page);

        return $this->render('catalog/index.html.twig', [
            'paginator' => $products,
            'slug'      => $slug,
            'routeName' => $_route
        ]);
    }

    /**
     * @param string $slug
     * @param int $page
     * @param string $_route
     * @return Response
     */
    #[Route('/catalog/tag/{slug}/{page}', name: 'catalog_tag_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function showByTag(string $slug, int $page, string $_route): Response
    {
        $products = $this->doctrine->getRepository(Product::class)->findByTag($page, $slug);

        return $this->render('catalog/index.html.twig', [
            'paginator' => $products,
            'slug'      => $slug,
            'routeName' => $_route,
        ]);
    }

}