<?php

namespace App\Controller;

use App\Model\MachineManager;

class AdminMachineController extends AbstractController
{
    public function index(): string
    {
        $machineManager = new MachineManager();
        $machines = $machineManager->selectAll();
        return $this->twig->render('Admin/Machine/show.html.twig', ['machines' => $machines]);
    }

    public function addMachine()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $machine = array_map('trim', $_POST);
            $errors = $this->machineValidate($machine);

            if (empty($errors)) {
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
            $errors = $this->machineValidate($machine);

            if (empty($errors)) {
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
}
