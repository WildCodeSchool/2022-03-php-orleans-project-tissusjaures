<?php

namespace App\Controller;

use App\Model\TipManager;
use App\Model\TipCategoryManager;

class AdminTipController extends AbstractController
{
    public function index(): string
    {
        $tipManager = new TipManager();
        $tips = $tipManager->selectAll();
        return $this->twig->render('Admin/Tips/index.html.twig', ['tips' => $tips]);
    }
}
