<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Tag;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CatalogController extends AbstractController
{
    #[Route('/catalog/{categorySlug}', name: 'catalog_category', defaults: ['page' => '1'])]
    #[Route('/catalog/{categorySlug}/{page}', name: 'catalog_category_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function showByCategory(ManagerRegistry $doctrine, $categorySlug, $page, string $_route): Response
    {
        $products = $doctrine
            ->getRepository(Product::class)
            ->findByCategory($page, $categorySlug);
        $categories = $doctrine->getRepository(Category::class)->findAll();
        $tags = $doctrine->getRepository(Tag::class)->findAll();

        return $this->render('catalog/index.html.twig', [
            'paginator' => $products,
            'categories' => $categories,
            'categorySlug' => $categorySlug,
            'tags' => $tags,
            'routeName' => $_route
        ]);
    }

    #[Route('/catalog/tag/{tagSlug}', name: 'catalog_tag', defaults: ['page' => '1'])]
    #[Route('/catalog/tag/{tagSlug}/{page}', name: 'catalog_tag_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function showByTag(ManagerRegistry $doctrine, $tagSlug, $page, string $_route): Response
    {
        $products = $doctrine
            ->getRepository(Product::class)
            ->findByTag($page, $tagSlug);
        $categories = $doctrine->getRepository(Category::class)->findAll();
        $tags = $doctrine->getRepository(Tag::class)->findAll();

        return $this->render('catalog/index.html.twig', [
            'paginator' => $products,
            'categories' => $categories,
            'categorySlug' => $tagSlug,
            'tags' => $tags,
            'routeName' => $_route,
        ]);
    }
}