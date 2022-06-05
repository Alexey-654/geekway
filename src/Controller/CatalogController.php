<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog/{slug}/{page}', name: 'catalog_category_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function showByCategory(ManagerRegistry $doctrine, string $slug, int $page, string $_route): Response
    {
        $products = $doctrine
            ->getRepository(Product::class)
            ->findByCategory($page, $slug);

        return $this->render('catalog/index.html.twig', [
            'paginator' => $products,
            'slug' => $slug,
            'routeName' => $_route
        ]);
    }

    #[Route('/catalog/tag/{slug}/{page}', name: 'catalog_tag_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function showByTag(ManagerRegistry $doctrine, string $slug, int $page, string $_route): Response
    {
        $products = $doctrine
            ->getRepository(Product::class)
            ->findByTag($page, $slug);

        return $this->render('catalog/index.html.twig', [
            'paginator' => $products,
            'slug' => $slug,
            'routeName' => $_route,
        ]);
    }

}