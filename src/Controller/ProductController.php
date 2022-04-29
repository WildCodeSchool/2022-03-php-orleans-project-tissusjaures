<?php

namespace App\Controller;

use App\Model\ClothManager;
use App\Model\MachineManager;
use App\Model\ClothCategoryManager;
use App\Model\MachineCategoryManager;

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
}
