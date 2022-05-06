<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MainPageController extends AbstractController
{
    #[Route('/', name: 'main_page', methods: ['GET', 'HEAD'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();
        $categories = $doctrine->getRepository(Category::class)->findAll();
        $tags = $doctrine->getRepository(Tag::class)->findAll();

        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'products' => $products,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }
}