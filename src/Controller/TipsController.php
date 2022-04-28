<?php

namespace App\Controller;

use App\Model\TipsManager;

class TipsController extends AbstractController
{
    public function showMonthlyTip(): string
    {
        $tipManager = new TipsManager();
        $monthlyTip = $tipManager->selectMonthlyTip();

        return $this->twig->render('Tips/tips.html.twig', ['monthlyTip' => $monthlyTip]);
    }
}
