<?php

namespace App\Controller;

use App\Model\LexiconManager;

class LexiconController extends AbstractController
{
    public function index(): string
    {
        $user = $this->getUser();
        $lexiconManager = new LexiconManager();
        $lexicons = $lexiconManager->selectAll();
        return $this->twig->render('Admin/Lexicon/show.html.twig', [
            'lexicons' => $lexicons,
            'user' => $user,
        ]);
    }

    public function addLexicon()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lexicon = array_map('trim', $_POST);
            $errors = $this->lexiconValidate($lexicon);

            if (empty($errors)) {
                $lexiconManager = new LexiconManager();
                $lexiconManager->insert($lexicon);
                header('Location: /admin/lexicons/');
            }
        }
        return $this->twig->render('Admin/Lexicon/add.html.twig');
    }

    public function deleteLexicon(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $lexiconManager = new LexiconManager();
            $lexiconManager->delete((int)$id);

            header('Location:/admin/lexiques/');
        }
    }

    private function lexiconValidate(array $lexicon): array
    {
        $errors = [];
        if (empty($lexicon['name'])) {
            $errors[] = 'Le champ nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($lexicon['name']) > $nameMaxLength) {
            $errors[] = 'Le nom ne doit pas dépasser les 100 caractères';
        }

        if (empty($lexicon['description'])) {
            $errors[] = 'Le champ description est obligatoire';
        }
        return $errors;
    }
}
