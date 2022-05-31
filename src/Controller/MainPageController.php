<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MainPageController extends AbstractController
{
    #[Route('/', name: 'main_page', methods: ['GET', 'HEAD'])]
    public function index(ManagerRegistry $doctrine, string $_route): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();

        return $this->render('main_page/index.html.twig', [
            'routeName' => $_route,
            'products' => $products,
        ]);
    }
}