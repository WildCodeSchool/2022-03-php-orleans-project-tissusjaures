<?php

namespace App\Controller;

use App\Model\TipsManager;

class TipsController extends AbstractController
{
    public function showTips(): string
    {
        $tipManager = new TipsManager();
        $monthlyTip = $tipManager->selectMonthlyTip();
        $tips = $tipManager->selectTips();
        return $this->twig->render('Tips/tips.html.twig', ['monthlyTip' => $monthlyTip, 'tips' => $tips]);
    }
}
