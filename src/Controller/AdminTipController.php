<?php

namespace App\Controller;

use App\Model\TipManager;
use App\Model\TipCategoryManager;

class AdminTipController extends AbstractController
{
    public function index(): string
    {
        if ($this->getUser() === null) {
            header('HTTP/1.0 403 Forbidden');
            return "Vous n'êtes pas autorisé à visiter cette page.";
        }

        $tipManager = new TipManager();
        $tips = $tipManager->selectAll();
        return $this->twig->render('Admin/Tips/index.html.twig', [
            'tips' => $tips,
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
