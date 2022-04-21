<?php

namespace App\Controller;

use App\Model\AdminClothManager;
use App\Model\CategoryManager;

class AdminClothController extends AbstractController
{
    public function addCloth()
    {
        $clothItems = $errors = [];
        $adminCategories = new CategoryManager();
        $categories = $adminCategories->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clothItems = array_map('trim', $_POST);
            $errors = $this->clothValidate($clothItems);
            var_dump($clothItems['cloth_categories_id']);
            var_dump($clothItems['price']);

            if (empty($errors)) {
                $clothManager = new AdminClothManager();
                $clothManager->insert($clothItems);
                header('Location: /admin/addcloth');
            }
        }
        return $this->twig->render('Admin/Cloth/add.html.twig', [
            'categories' => $categories, 'clothItems' => $clothItems,
            'errors' => $errors
        ]);
    }
    private function clothValidate($clothItems): array
    {
        $errors = [];
        if (empty($clothItems['name'])) {
            $errors[] = 'Le champ nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($clothItems['name']) > $nameMaxLength) {
            $errors[] = 'Le nom ne doit pas dépasser les 100 caractères';
        }

        if (empty($clothItems['price'])) {
            $errors[] = 'Le champ prix est obligatoire';
        }

        if (!is_float(floatval($clothItems['price']))) {
            $errors[] = 'Le prix doit être un nombre';
        }

        if (empty($clothItems['cloth_categories_id'])) {
            $errors[] = 'Le champ catégorie est obligatoire';
        }
        return $errors;
    }
}
