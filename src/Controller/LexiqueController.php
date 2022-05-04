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
        $lexiqueManager = new LexiqueManager();
        $lexiques = $lexiqueManager->selectAll();

        return $this->twig->render('Lexique/index.html.twig', [
            'lexiques' => $lexiques,
            'tipCategories' => $tipCategories,
        ]);
    }
}
