<?php

namespace App\Controller;

use App\Model\TutorialManager;
use App\Model\TipCategoryManager;

class TutorialController extends AbstractController
{
    public function index(): string
    {
        $tutorialManager = new TutorialManager();
        $tipCategoryManager = new TipCategoryManager();
        $tutorials = $tutorialManager->selectAll();
        $tipCategories = $tipCategoryManager->selectAll();
        return $this->twig->render('/Tips/Tutorials/index.html.twig', ['tutorials' => $tutorials,
        'tipCategories' => $tipCategories
    ]);
    }
}
