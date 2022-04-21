<?php

namespace App\Controller;

use App\Model\ClothesManager;
use App\Model\MachinesManager;
use App\Model\ProductCategoryManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $categoryManager = new ProductCategoryManager();
        $productCategories = $categoryManager->selectAll();

        $clothesManager = new ClothesManager();
        $products = $clothesManager->selectAll();
        $machinesManager = new MachinesManager();
        $machines = $machinesManager->selectAll();

        return $this->twig->render('Item/index.html.twig', [
            'products' => $products, 'machines' => $machines,
            'categories' => $productCategories,
        ]);
    }

    public function productCategory(): string
    {
        $categoryManager = new ProductCategoryManager();
        $productCategories = $categoryManager->selectAll();

        return $this->twig->render('Item/index.html.twig', ['categories' => $productCategories]);
    }
}
