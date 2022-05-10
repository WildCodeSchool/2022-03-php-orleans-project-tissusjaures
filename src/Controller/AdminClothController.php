<?php

namespace App\Controller;

use App\Model\ClothManager;
use App\Model\ClothCategoryManager;

class AdminClothController extends AbstractController
{
    public const AUTHORIZED_MIMES = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    public const MAX_FILE_SIZE = 1000000;
    public const MAX_NAME_LENGTH = 100;

    public function index(): string
    {
        if ($this->getUser() === null) {
            header('HTTP/1.0 403 Forbidden');
            return "Vous n'êtes pas autorisé à visiter cette page.";
        }

        $clothList = new ClothManager();
        $clothItems = $clothList->selectAll();
        return $this->twig->render('Admin/Cloth/show.html.twig', [
            'clothItems' => $clothItems,
        ]);
    }

    public function addCloth()
    {
        $clothItems = $formErrors = $checkboxErrors = $errors = [];
        $adminCategories = new ClothCategoryManager();
        $categories = $adminCategories->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clothItems = array_map('trim', $_POST);
            $imageFile = $_FILES['image'];
            $formErrors = $this->clothValidate($clothItems, $categories);
            $checkboxErrors = $this->checkboxValidate($clothItems);
            $imageErrors = $this->validateImage($imageFile);
            $errors = [...$formErrors, ...$checkboxErrors, ...$imageErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('', true) . '.' . $extension;

                move_uploaded_file($imageFile['tmp_name'], UPLOAD_PATH . '/' . $imageName);

                $clothItems['image'] = $imageName;
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
            $imageFile = $_FILES['image'];
            $formErrors = $this->clothValidate($clothItems, $categories);
            $checkboxErrors = $this->checkboxValidate($clothItems);
            $imageErrors = $this->validateImage($imageFile);
            $errors = [...$formErrors, ...$checkboxErrors, ...$imageErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('', true) . '.' . $extension;

                move_uploaded_file($imageFile['tmp_name'], UPLOAD_PATH . '/' . $imageName);

                $clothItems['image'] = $imageName;
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

    private function validateImage(array $files): array
    {
        $imageErrors = [];
        if ($files['error'] === UPLOAD_ERR_NO_FILE) {
            $imageErrors[] = 'Le fichier est obligatoire';
        } elseif ($files['error'] !== UPLOAD_ERR_OK) {
            $imageErrors[] = 'Problème de téléchargement du fichier';
        } else {
            if ($files['size'] > self::MAX_FILE_SIZE) {
                $imageErrors[] = 'Le fichier doit faire moins de ' . self::MAX_FILE_SIZE / 1000000 . 'Mo';
            }

            if (!in_array(mime_content_type($files['tmp_name']), self::AUTHORIZED_MIMES)) {
                $imageErrors[] = 'Le fichier doit être de type ' . implode(', ', self::AUTHORIZED_MIMES);
            }
        }
        return $imageErrors;
    }
}
