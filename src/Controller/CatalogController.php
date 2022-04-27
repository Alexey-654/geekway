<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CatalogController extends AbstractController
{
    #[Route('/catalog/{categorySlug}', name: 'catalog', defaults: ['page' => '1'], methods: ['GET', 'HEAD'])]
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

}