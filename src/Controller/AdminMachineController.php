<?php

namespace App\Controller;

use App\Model\MachineManager;

class AdminMachineController extends AbstractController
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

        $machineManager = new MachineManager();
        $machines = $machineManager->selectAll();
        return $this->twig->render('Admin/Machine/show.html.twig', [
            'machines' => $machines,
        ]);
    }

    public function addMachine()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $machine = array_map('trim', $_POST);
            $imageFile = $_FILES['image'];
            $formErrors = $this->machineValidate($machine);
            $checkboxErrors = $this->checkboxValidate($machine);
            $imageErrors = $this->validateImage($imageFile);
            $errors = [...$formErrors, ...$checkboxErrors, ...$imageErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('', true) . '.' . $extension;

                move_uploaded_file($imageFile['tmp_name'], UPLOAD_PATH . '/' . $imageName);

                $machine['image'] = $imageName;
                $machineManager = new MachineManager();
                $machineManager->insert($machine);
                header('Location: /admin/machines/');
            }
        }
        return $this->twig->render('Admin/Machine/add.html.twig');
    }

    public function editMachine($id): string
    {
        $errors = $machine = [];
        $machineManager = new MachineManager();
        $machine = $machineManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $machine = array_map('trim', $_POST);
            $machine['id'] = $id;
            $imageFile = $_FILES['image'];
            $formErrors = $this->machineValidate($machine);
            $checkboxErrors = $this->checkboxValidate($machine);
            $imageErrors = $this->validateImage($imageFile);
            $errors = [...$formErrors, ...$checkboxErrors, ...$imageErrors];

            /** @phpstan-ignore-next-line */
            if (empty($errors)) {
                $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('', true) . '.' . $extension;

                move_uploaded_file($imageFile['tmp_name'], UPLOAD_PATH . '/' . $imageName);

                $machine['image'] = $imageName;
                $machineManager->update($machine);
                header('Location: /admin/machines/');
            }
        }
        return $this->twig->render('Admin/Machine/edit.html.twig', [
            'machine' => $machine,
            'errors' => $errors
        ]);
    }

    public function deleteMachine(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $machineManager = new MachineManager();
            $machineManager->delete((int)$id);

            header('Location:/admin/machines/');
        }
    }

    private function machineValidate(array $machine): array
    {
        $errors = [];
        if (empty($machine['name'])) {
            $errors[] = 'Le champ nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($machine['name']) > $nameMaxLength) {
            $errors[] = 'Le nom ne doit pas dépasser les 100 caractères';
        }

        if (empty($machine['price'])) {
            $errors[] = 'Le champ prix est obligatoire';
        }

        if (!is_float(floatval($machine['price']))) {
            $errors[] = 'Le prix doit être un nombre';
        }

        if (empty($machine['description'])) {
            $errors[] = 'Le champ description est obligatoire';
        }
        return $errors;
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
