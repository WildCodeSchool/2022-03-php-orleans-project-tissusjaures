<?php

namespace App\Controller;

use App\Model\TipsManager;

class TipsController extends AbstractController
{
    public function showMonthlyTip(): string
    {
        $tipManager = new TipsManager();
        $tips = $tipManager->selectByIsMonthlyTip();

        return $this->twig->render('Tips/tips.html.twig', ['tips' => $tips]);
    }
}