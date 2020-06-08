<?php

namespace App\Controller;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function index(ProductRepository $productRepository)
    {
        // $products = $pdo->query("SELECT * FROM product")->fetchAll();
//        $products = $productRepository->findAll();
        $products = $productRepository->findBy([], [], 6);
        return $this->render('home/index.html.twig', [
            'productList' => $products,
        ]);
    }
}
