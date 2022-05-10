<?php

namespace App\Controller;

use App\Model\ClothCategoryManager;
use App\Model\MachineCategoryManager;
use App\Model\ClothManager;
use App\Model\MachineManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $clothCategoryManager = new ClothCategoryManager();
        $clothCategories = $clothCategoryManager->selectAll();
        $machCategoryManager = new MachineCategoryManager();
        $machineCategories = $machCategoryManager->selectAll();

        return $this->twig->render('Products/index.html.twig', [
            'clothCategories' => $clothCategories, 'machineCategories' => $machineCategories,
        ]);
    }

    public function showProductBySearch(string $search)
    {
        $clothCategoryManager = new ClothCategoryManager();
        $clothCategories = $clothCategoryManager->selectAll();
        $machCategoryManager = new MachineCategoryManager();
        $machineCategories = $machCategoryManager->selectAll();

        $clothManager = new ClothManager();
        $clothes = $clothManager->selectBySearch($search);
        $machineManager = new MachineManager();
        $machines = $machineManager->selectBySearch($search);

        $products = [...$machines, ...$clothes];

        return $this->twig->render('Products/search.html.twig', [
            'search' => $search,
            'products' => $products,
            'clothCategories' => $clothCategories,
            'machineCategories' => $machineCategories,
        ]);
    }
}
