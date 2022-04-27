<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    #[Route('/product/{categorySlug}', name: 'product', defaults: ['page' => '1'], methods: ['GET', 'HEAD'])]
    #[Route('/product/{page}', name: 'product_index_paginated', requirements: ['page' => '\d+'], defaults: ['page' => '1'])]
    public function index(ManagerRegistry $doctrine, $categorySlug, $page): Response
    {
        $products = $doctrine
            ->getRepository(Product::class)
            ->findLatest($page, $categorySlug);

        $categories = $doctrine->getRepository(Category::class)->findAll();

        return $this->render('product/index.html.twig', [
            'paginator' => $products,
            'categories' => $categories,
        ]);
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());
    }
}