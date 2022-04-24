<?php

namespace App\Controller;

use App\Model\ClothManager;
use App\Model\ProductCategoryManager;

class ClothController extends AbstractController
{
    public function index(): string
    {
        $categoryManager = new ProductCategoryManager();
        $productCategories = $categoryManager->selectAll();

        $clothManager = new ClothManager();
        $clothes = $clothManager->selectAll();

        return $this->twig->render('Products/showTissus.html.twig', [
            'clothes' => $clothes,
            'categories' => $productCategories,
        ]);
    }
}
