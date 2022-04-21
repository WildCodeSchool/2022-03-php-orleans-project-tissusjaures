<?php

namespace App\Controller;

use App\Model\ClothManager;
use App\Model\CategoryManager;

class AdminClothController extends AbstractController
{
    public function addCloth()
    {
        $adminCategories = new CategoryManager();
        $categories = $adminCategories->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cloth = array_map('trim', $_POST);

            $errors = $this->clothValidate($cloth);

            if (empty($errors)) {
                $clothManager = new ClothManager();
                $clothManager->insert($cloth);
                header('Location: /admin/tissus');
            }
        }
        return $this->twig->render('Admin/Cloth/add.html.twig', [
            'categories' => $categories,
        ]);
    }
    public function clothValidate($cloth): array
    {
        $errors = [];
        if (empty($cloth['name'])) {
            $errors[] = 'Le champ nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($cloth['name']) > $nameMaxLength) {
            $errors[] = 'Le nom ne doit pas dépasser les 100 caractères';
        }

        if (empty($cloth['price'])) {
            $errors[] = 'Le champ prix est obligatoire';
        }

        if (!is_float($cloth['price'])) {
            $errors[] = 'Le prix doit être un nombre';
        }

        if (empty($cloth['cloth_categories_id'])) {
            $errors[] = 'Le champ catégorie est obligatoire';
        }
        return $errors;
    }
}
