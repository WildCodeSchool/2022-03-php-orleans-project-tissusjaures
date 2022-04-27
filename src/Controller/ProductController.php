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

        $clothManager = new ClothManager();
        $clothes = $clothManager->selectAll();
        $machineManager = new MachineManager();
        $machines = $machineManager->selectAll();

        return $this->twig->render('Products/index.html.twig', [
            'clothes' => $clothes, 'machines' => $machines,
            'clothCategories' => $clothCategories, 'machineCategories' => $machineCategories,
        ]);
    }
}
