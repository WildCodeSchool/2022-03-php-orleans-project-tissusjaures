<?php

namespace App\Controller;

use App\Model\TipManager;

class AdminTipController extends AbstractController
{
    public const AUTHORIZED_MIMES = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    public const MAX_FILE_SIZE = 1000000;
    public const MAX_NAME_LENGTH = 100;

    public function index(): string
    {
        $tipManager = new TipManager();
        $tips = $tipManager->selectAll();
        return $this->twig->render('Admin/Tips/index.html.twig', ['tips' => $tips]);
    }

    public function addTip(): ?string
    {
        $tip = $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tip = array_map('trim', $_POST);
            $tipErrors = $this->tipValidate($tip);

            $imageFile = $_FILES['image'];
            $imageErrors = $this->validateImage($imageFile);

            $errors = [...$tipErrors, ...$imageErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('', true) . '.' . $extension;

                move_uploaded_file($imageFile['tmp_name'], UPLOAD_PATH . '/' . $imageName);

                $tipManager = new TipManager();
                $tip['image'] = $imageName;
                $tipManager->insert($tip);
                header('Location: /admin/astuces/');
            }
        }
        return $this->twig->render('Admin/Tips/add.html.twig', [
            'tip' => $tip,
            'errors' => $errors
        ]);
    }

    public function editTip($id): ?string
    {
        $tip = $errors = [];
        $tipManager = new TipManager();
        $tip = $tipManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tip = array_map('trim', $_POST);
            $tip['id'] = $id;
            $imageFile = $_FILES['image'];
            $tipErrors = $this->tipValidate($tip);
            $imageErrors = $this->validateImage($imageFile);

            $errors = [...$tipErrors, ...$imageErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('', true) . '.' . $extension;

                move_uploaded_file($imageFile['tmp_name'], UPLOAD_PATH . '/' . $imageName);

                $tipManager = new TipManager();
                $tip['image'] = $imageName;
                $tipManager->update($tip);
                header('Location: /admin/astuces/');
            }
        }
        return $this->twig->render('Admin/Tips/edit.html.twig', [
            'tip' => $tip,
            'errors' => $errors
        ]);
    }

    private function tipValidate(array $tip): array
    {
        $tipErrors = [];
        if (empty($tip['name'])) {
            $tipErrors[] = 'Le champ nom est obligatoire';
        }

        if (strlen($tip['name']) > self::MAX_NAME_LENGTH) {
            $tipErrors[] = 'Le nom ne doit pas dépasser les 100 caractères';
        }

        if (empty($tip['content'])) {
            $tipErrors[] = 'Le champ description est obligatoire';
        }

        if (!empty($tip['is_monthly_tip']) && intval($tip['is_monthly_tip']) !== 1) {
            $tipErrors[] = 'Ceci n\'est pas une option valide';
        }

        return $tipErrors;
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

    public function deleteTip(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $tipManager = new TipManager();
            $tipManager->delete((int)$id);

            header('Location:/admin/astuces/');
        }
    }
}
