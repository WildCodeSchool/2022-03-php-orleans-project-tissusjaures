<?php

namespace App\Controller;

use App\Model\LexiconManager;
use App\Model\TipCategoryManager;

class LexiconController extends AbstractController
{
    public function index(): string
    {
        $tipCategoryManager = new TipCategoryManager();
        $tipCategories = $tipCategoryManager->selectAll();
        $lexiconManager = new LexiconManager();
        $lexicons = $lexiconManager->selectAll();

        return $this->twig->render('Lexicon/index.html.twig', [
            'lexicons' => $lexicons,
            'tipCategories' => $tipCategories,
        ]);
    }
}
