<?php

namespace App\Controller;

use App\Model\TutorialManager;

class TutorialController extends AbstractController
{
    public function index(): string
    {
        $tutorialManager = new TutorialManager();
        $tutorials = $tutorialManager->selectAll();
        return $this->twig->render('Tutorials/index.html.twig', ['tutorials' => $tutorials]);
    }
}
