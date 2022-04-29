<?php

namespace App\Controller;

use App\Model\ClothManager;
use App\Model\ClothCategoryManager;
use App\Model\MachineCategoryManager;

class ClothController extends AbstractController
{
    public function index(): string
    {
        $clothCategoryManager = new ClothCategoryManager();
        $clothCategories = $clothCategoryManager->selectAll();
        $machCategoryManager = new MachineCategoryManager();
        $machineCategories = $machCategoryManager->selectAll();

        $clothManager = new ClothManager();
        $clothes = $clothManager->selectAll();

        return $this->twig->render('Products/tissus.html.twig', [
            'clothes' => $clothes,
            'clothCategories' => $clothCategories,
            'machineCategories' => $machineCategories
        ]);
    }

    public function showClothByCategory(int $id): string
    {
        $clothCategoryManager = new ClothCategoryManager();
        $clothCategories = $clothCategoryManager->selectAll();
        $machCategoryManager = new MachineCategoryManager();
        $machineCategories = $machCategoryManager->selectAll();

        $clothManager = new ClothManager();
        $clothes = $clothManager->selectAllById($id);

        return $this->twig->render('Products/tissus.html.twig', [
            'clothes' => $clothes,
            'id' => $id,
            'clothCategories' => $clothCategories,
            'machineCategories' => $machineCategories,
        ]);
    }
}
