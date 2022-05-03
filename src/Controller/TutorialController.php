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
        return $this->twig->render('/Tutorials/index.html.twig', ['tutorials' => $tutorials,
        'tipCategories' => $tipCategories
        ]);
    }

    public function show($id): string
    {
        $tutorialManager = new TutorialManager();
        $tutorial = $tutorialManager->selectOneById($id);
        return $this->twig->render('/Tutorials/show.html.twig', ['tutorial' => $tutorial,
        ]);
    }
}
