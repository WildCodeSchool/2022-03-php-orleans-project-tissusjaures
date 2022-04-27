<?php

namespace App\Controller;

use App\Model\AdminMachineManager;
use App\Model\CategoryManager;

class AdminClothController extends AbstractController
{
    public function addMachine()
    {
        $machines = $errors = [];
        $adminCategories = new CategoryManager();
        $categories = $adminCategories->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $machineManager = array_map('trim', $_POST);
            $errors = $this->machineValidate($machines);

            if (empty($errors)) {
                $machineManager = new AdminMachineManager();
                $machineManager->insert($machines);
                header('Location: /admin/machine/add');
            }
        }
        return $this->twig->render('Admin/machine/add.html.twig', [
            'categories' => $categories, 'machines' => $machines,
            'errors' => $errors
        ]);
    }
    private function machineValidate(array $machines): array
    {
        $errors = [];
        if (empty($machines['name'])) {
            $errors[] = 'Le champ nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($machines['name']) > $nameMaxLength) {
            $errors[] = 'Le nom ne doit pas dépasser les 100 caractères';
        }

        if (empty($machines['price'])) {
            $errors[] = 'Le champ prix est obligatoire';
        }

        if (!is_float(floatval($machines['price']))) {
            $errors[] = 'Le prix doit être un nombre';
        }

        if (empty($machines['description'])) {
            $errors[] = 'Le champ description est obligatoire';
        }

        return $errors;
    }
}
