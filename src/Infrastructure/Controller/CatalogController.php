<?php

namespace App\Infrastructure\Controller;

use App\Domain\Entity\Category;
use App\Domain\Entity\Product;
use App\Domain\Entity\Tag;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/catalog/{slug}/{page}', name: 'catalog_category_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function showByCategory(string $slug, int $page, string $_route): Response
    {
        $products     = $this->doctrine->getRepository(Product::class)->findByCategorySlug($slug, $page);
        $categoryName = $this->doctrine->getRepository(Category::class)->findOneBy(['slug' => $slug])->getName();

        return $this->render('catalog/index.html.twig', [
            'paginator' => $products,
            'slug'      => $slug,
            'groupName' => $categoryName,
            'routeName' => $_route
        ]);
    }

    #[Route('/catalog/tag/{slug}/{page}', name: 'catalog_tag_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function showByTag(string $slug, int $page, string $_route): Response
    {
        $products = $this->doctrine->getRepository(Product::class)->findByTag($page, $slug);
        $tagName  = $this->doctrine->getRepository(Tag::class)->findOneBy(['slug' => $slug])->getName();

        return $this->render('catalog/index.html.twig', [
            'paginator' => $products,
            'slug'      => $slug,
            'groupName' => $tagName,
            'routeName' => $_route,
        ]);
    }

}