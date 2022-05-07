<?php

namespace App\Controller;

use App\Model\TipManager;
use App\Model\TipCategoryManager;

class AdminTipController extends AbstractController
{
    public function index(): string
    {
        $user = $this->getUser();
        $tipManager = new TipManager();
        $tips = $tipManager->selectAll();
        return $this->twig->render('Admin/Tips/index.html.twig', [
            'tips' => $tips,
            'user' => $user,
        ]);
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
