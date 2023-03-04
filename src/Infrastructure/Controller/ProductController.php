<?php

namespace App\Infrastructure\Controller;

use App\Domain\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    #[Route('/product/{slug}', name: 'product_show')]
    public function show(ManagerRegistry $doctrine, string $slug): Response
    {
        $product = $doctrine->getRepository(Product::class)->findBySlug($slug);
        if (!$product) {
            throw $this->createNotFoundException('No product found for slug ' . $slug);
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

}