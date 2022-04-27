<?php

namespace App\Controller;

use App\Model\AdminClothManager;
use App\Model\CategoryManager;

class AdminClothController extends AbstractController
{
    public function index(): string
    {
        $clothList = new AdminClothManager();
        $clothItems = $clothList->selectAll();
        return $this->twig->render('Admin/Cloth/show.html.twig', ['clothItems' => $clothItems]);
    }

    public function addCloth()
    {
        $clothItems = $errors = [];
        $adminCategories = new CategoryManager();
        $categories = $adminCategories->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clothItems = array_map('trim', $_POST);
            $errors = $this->clothValidate($clothItems, $categories);

            if (empty($errors)) {
                $clothManager = new AdminClothManager();
                $clothManager->insert($clothItems);
                header('Location: /admin/cloth/');
            }
        }
        return $this->twig->render('Admin/Cloth/add.html.twig', [
            'categories' => $categories, 'clothItems' => $clothItems,
            'errors' => $errors
        ]);
    }

    public function editCloth($id): string
    {
        $errors = $clothItems = [];
        $adminCategories = new CategoryManager();
        $categories = $adminCategories->selectAll();
        $clothList = new AdminClothManager();
        $clothItems = $clothList->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clothItems = array_map('trim', $_POST);
            $clothItems['id'] = $id;
            $errors = $this->clothValidate($clothItems, $categories);

            if (empty($errors)) {
                $clothList->update($clothItems);
                header('Location: /admin/cloth/');
            }
        }
        return $this->twig->render('Admin/Cloth/edit.html.twig', [
            'categories' => $categories, 'clothItems' => $clothItems,
            'errors' => $errors
        ]);
    }

    public function deleteCloth(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $clothManager = new AdminClothManager();
            $clothManager->delete($id);

            header('Location:/admin/cloth');
        }
    }

    private function clothValidate(array $clothItems, array $categories): array
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
        if (!empty($clothItems['cloth_categories_id'])) {
            if (!in_array($clothItems['cloth_categories_id'], array_column($categories, 'id'))) {
                $errors[] = "Merci de choisir une catégorie valide";
            }
        }
        return $errors;
    }
}
