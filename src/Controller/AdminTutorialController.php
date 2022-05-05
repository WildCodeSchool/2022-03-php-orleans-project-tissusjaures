<?php

namespace App\Controller;

use App\Model\TutorialManager;

class AdminTutorialController extends AbstractController
{
    public const AUTHORIZED_MIMES = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    public const MAX_FILE_SIZE = 1000000;
    public const MAX_NAME_LENGTH = 100;

    public function index(): string
    {
        $tutorialManager = new TutorialManager();
        $tutorials = $tutorialManager->selectAll();
        return $this->twig->render('Admin/Tutorials/index.html.twig', ['tutorials' => $tutorials]);
    }

    public function addTutorial(): ?string
    {
        $tutorial = $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tutorial = array_map('trim', $_POST);
            $imageFile = $_FILES['image'];
            $tutorialErrors = $this->tutorialValidate($tutorial);
            $imageErrors = $this->validateImage($imageFile);

            $errors = [...$tutorialErrors, ...$imageErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('', true) . '.' . $extension;

                move_uploaded_file($imageFile['tmp_name'], UPLOAD_PATH . '/' . $imageName);

                $tutorialManager = new TutorialManager();
                $tutorial['image'] = $imageName;
                $tutorialManager->insert($tutorial);
                header('Location: /admin/tutoriels/');
            }
        }
        return $this->twig->render('Admin/Tips/add.html.twig', [
            'tutorial' => $tutorial,
            'errors' => $errors
        ]);
    }

    private function tutorialValidate(array $tip): array
    {
        $tutorialErrors = [];
        if (empty($tip['name'])) {
            $tutorialErrors[] = 'Le champ nom est obligatoire';
        }

        if (strlen($tip['name']) > self::MAX_NAME_LENGTH) {
            $tutorialErrors[] = 'Le nom ne doit pas dépasser les 100 caractères';
        }

        if (empty($tip['content'])) {
            $tutorialErrors[] = 'Le champ description est obligatoire';
        }

        return $tutorialErrors;
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
