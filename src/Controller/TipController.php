<?php

namespace App\Controller;

use App\Model\TipManager;
use App\Model\TipCategoryManager;

class TipController extends AbstractController
{
    public function showTips(): string
    {
        $tipCategoryManager = new TipCategoryManager();
        $tipCategories = $tipCategoryManager->selectAll();

        $tipManager = new TipManager();
        $monthlyTip = $tipManager->selectMonthlyTip();
        $tips = $tipManager->selectTips();
        return $this->twig->render(
            'Tips/tips.html.twig',
            ['tipCategories' => $tipCategories, 'monthlyTip' => $monthlyTip, 'tips' => $tips]
        );
    }

    public function showTipById($id): string
    {
        $tipManager = new TipManager();
        $tip = $tipManager->selectOneById($id);
        return $this->twig->render(
            'Tips/show.html.twig',
            ['tip' => $tip]
        );
    }
}
