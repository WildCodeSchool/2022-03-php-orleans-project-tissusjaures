<?php

namespace App\Controller;

use App\Model\TipsManager;
use App\Model\TipCategoryManager;

class TipsController extends AbstractController
{
    public function showTips(): string
    {
        $tipCategoryManager = new TipCategoryManager();
        $tipCategories = $tipCategoryManager->selectAll();

        $tipManager = new TipsManager();
        $monthlyTip = $tipManager->selectMonthlyTip();

        return $this->twig->render(
            'Tips/tips.html.twig',
            ['tipCategories' => $tipCategories, 'monthlyTip' => $monthlyTip]
        );
    }
}
