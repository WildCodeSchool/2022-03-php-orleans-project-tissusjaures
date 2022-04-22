<?php

namespace App\Controller;

use App\Model\ClothManager;
use App\Model\MachineManager;
use App\Model\ProductCategoryManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $categoryManager = new ProductCategoryManager();
        $productCategories = $categoryManager->selectAll();

        $clothManager = new ClothManager();
        $clothes = $clothManager->selectAll();
        $machineManager = new MachineManager();
        $machines = $machineManager->selectAll();

        return $this->twig->render('Products/index.html.twig', [
            'clothes' => $clothes, 'machines' => $machines,
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
