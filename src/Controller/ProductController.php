<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll('name');

        return $this->twig->render('Item/index.html.twig', ['products' => $products]);
    }
}
