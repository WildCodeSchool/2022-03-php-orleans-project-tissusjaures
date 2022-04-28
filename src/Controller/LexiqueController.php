<?php

namespace App\Controller;

use App\Model\LexiqueManager;

class LexiqueController extends AbstractController
{
    public function index(): string
    {
        $lexiqueManager = new LexiqueManager();
        $lexiques = $lexiqueManager->selectAll();

        return $this->twig->render('Lexique/index.html.twig', ['lexiques' => $lexiques]);
    }
}
