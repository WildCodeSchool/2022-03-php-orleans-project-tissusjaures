<?php

namespace App\Controller;

use App\Model\MachineManager;

class MachineController extends AbstractController
{
    public function index(): string
    {
        $machineManager = new MachineManager();
        $machine = $machineManager->selectAll('title');

        return $this->twig->render('machine/index.html.twig', ['machine' => $machine]);
    }

    public function show(int $id): string
    {
        $machineManager = new MachineManager();
        $machine = $machineManager->selectOneById($id);

        return $this->twig->render('machine/show.html.twig', ['machine' => $machine]);
    }

    public function edit(int $id): ?string
    {
        $machineManager = new MachineManager();
        $machine = $machineManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $machine = array_map('trim', $_POST);

            $machineManager->update($machine);

            header('Location: /machine/show?id=' . $id);

            return null;
        }
        return $this->twig->render('machine/edit.html.twig', [
            'machine' => $machine,
        ]);
    }

    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $machine = array_map('trim', $_POST);

            $machineManager = new MachineManager();
            $id = $machineManager->insert($machine);

            header('Location:/machine/show?id=' . $id);
            return null;
        }

        return $this->twig->render('machine/add.html.twig');
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $machineManager = new MachineManager();
            $machineManager->delete((int)$id);

            header('Location:/machine');
        }
    }
}
