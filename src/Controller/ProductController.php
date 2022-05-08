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
    #[Route('/product/{slug}', name: 'product_show')]
    public function show(ManagerRegistry $doctrine, string $slug): Response
    {
        $product = $doctrine
            ->getRepository(Product::class)
            ->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for name ' . $slug
            );
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

}