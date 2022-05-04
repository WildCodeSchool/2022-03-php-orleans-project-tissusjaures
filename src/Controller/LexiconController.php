<?php

namespace App\Controller;

use App\Model\LexiqueManager;
use App\Model\TipCategoryManager;

class LexiqueController extends AbstractController
{
    public function index(): string
    {
        $tipCategoryManager = new TipCategoryManager();
        $tipCategories = $tipCategoryManager->selectAll();
        $lexiconManager = new LexiqueManager();
        $lexicons = $lexiconManager->selectAll();

        return $this->twig->render('Lexique/index.html.twig', [
            'lexicons' => $lexicons,
            'tipCategories' => $tipCategories,
        ]);
    }
}
