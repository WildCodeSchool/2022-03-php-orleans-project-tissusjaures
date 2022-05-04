<?php

namespace App\Controller;

use App\Model\MachineManager;
use App\Model\ClothCategoryManager;
use App\Model\MachineCategoryManager;

class MachineController extends AbstractController
{
    public function index(): string
    {
        $clothCategoryManager = new ClothCategoryManager();
        $clothCategories = $clothCategoryManager->selectAll();
        $machCategoryManager = new MachineCategoryManager();
        $machineCategories = $machCategoryManager->selectAll();

        $machineManager = new MachineManager();
        $machines = $machineManager->selectAll();

        return $this->twig->render('Products/machine.html.twig', [
            'machines' => $machines,
            'clothCategories' => $clothCategories,
            'machineCategories' => $machineCategories
        ]);
    }

    public function showMachineByCategory(int $id): string
    {
        $clothCategoryManager = new ClothCategoryManager();
        $clothCategories = $clothCategoryManager->selectAll();
        $machCategoryManager = new MachineCategoryManager();
        $machineCategories = $machCategoryManager->selectAll();

        $machineManager = new MachineManager();
        $machines = $machineManager->selectAllById($id);

        return $this->twig->render('Products/machine.html.twig', [
            'machines' => $machines,
            'id' => $id,
            'clothCategories' => $clothCategories,
            'machineCategories' => $machineCategories,
        ]);
    }
}
