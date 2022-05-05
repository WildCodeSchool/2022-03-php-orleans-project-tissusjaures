<?php

namespace App\Controller;

use App\Model\TutorialManager;

class AdminTutorialController extends AbstractController
{
    public function index(): string
    {
        $tutorialManager = new TutorialManager();
        $tutorials = $tutorialManager->selectAll();
        return $this->twig->render('Admin/Tutorials/index.html.twig', ['tutorials' => $tutorials]);
    }
}
