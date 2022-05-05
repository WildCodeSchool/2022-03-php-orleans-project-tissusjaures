<?php

namespace App\Controller;

use App\Model\ClothManager;
use App\Model\ClothCategoryManager;

class AdminClothController extends AbstractController
{
    public function index(): string
    {
        $clothList = new ClothManager();
        $clothItems = $clothList->selectAll();
        return $this->twig->render('Admin/Cloth/show.html.twig', ['clothItems' => $clothItems]);
    }

    public function addCloth()
    {
        $clothItems = $formErrors = $checkboxErrors = $errors = [];
        $adminCategories = new ClothCategoryManager();
        $categories = $adminCategories->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clothItems = array_map('trim', $_POST);
            $formErrors = $this->clothValidate($clothItems, $categories);
            $checkboxErrors = $this->checkboxValidate($clothItems);
            $errors = [...$formErrors, ...$checkboxErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $clothManager = new ClothManager();
                $clothManager->insert($clothItems);
                header('Location: /admin/tissus/');
            }
        }
        return $this->twig->render('Admin/Cloth/add.html.twig', [
            'categories' => $categories, 'clothItems' => $clothItems,
            'errors' => $errors
        ]);
    }

    public function editCloth($id): string
    {
        $formErrors = $clothItems = $checkboxErrors = $errors = [];
        
        $adminCategories = new ClothCategoryManager();
        $categories = $adminCategories->selectAll();
        $clothList = new ClothManager();
        $clothItems = $clothList->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clothItems = array_map('trim', $_POST);
            $clothItems['id'] = $id;
            $formErrors = $this->clothValidate($clothItems, $categories);
            $checkboxErrors = $this->checkboxValidate($clothItems);
            $errors = [...$formErrors, ...$checkboxErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $clothList->update($clothItems);
                header('Location: /admin/tissus/');
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
            $clothManager = new ClothManager();
            $clothManager->delete((int)$id);

            header('Location:/admin/tissus/');
        }
    }

    public function clothValidate(array $clothItems, array $categories): array
    {
        $formErrors = [];
        if (empty($clothItems['name'])) {
            $formErrors[] = 'Le champ nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($clothItems['name']) > $nameMaxLength) {
            $formErrors[] = 'Le nom ne doit pas dépasser les 100 caractères';
        }

        if (empty($clothItems['price'])) {
            $formErrors[] = 'Le champ prix est obligatoire';
        }

        if (!is_float(floatval($clothItems['price']))) {
            $formErrors[] = 'Le prix doit être un nombre';
        }

        if (empty($clothItems['cloth_categories_id'])) {
            $formErrors[] = 'Le champ catégorie est obligatoire';
        }

        if (
            !empty($clothItems['cloth_categories_id']
                && !in_array($clothItems['cloth_categories_id'], array_column($categories, 'id')))
        ) {
            $formErrors[] = "Merci de choisir une catégorie valide";
        }

        return $formErrors;
    }

    public function checkboxValidate(array $clothItems): array
    {
        $checkboxErrors = [];
        if (!empty($clothItems['is_on_sale']) && (intval($clothItems['is_on_sale']) !== 1)) {
            $checkboxErrors[] = 'Ceci n\'est pas une option valide !';
        }

        if (!empty($clothItems['is_new']) && intval($clothItems['is_new']) !== 1) {
            $checkboxErrors[] = 'Ceci n\'est pas une option valide !';
        }
        return $checkboxErrors;
    }
}
