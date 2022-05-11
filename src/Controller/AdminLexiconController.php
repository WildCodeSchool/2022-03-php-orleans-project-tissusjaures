<?php

namespace App\Controller;

use App\Model\LexiconManager;

class AdminLexiconController extends AbstractController
{
    public function index(): string
    {
        if ($this->getUser() === null) {
            header('Location:/connexion');
            return "";
        }

        $lexiconManager = new LexiconManager();
        $lexicons = $lexiconManager->selectAll();
        return $this->twig->render('Admin/Lexicon/index.html.twig', [
            'lexicons' => $lexicons,
        ]);
    }

    public function addLexicon()
    {
        if ($this->getUser() === null) {
            header('Location:/connexion');
            return "";
        }

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

    public function editLexicon($id): string
    {
        if ($this->getUser() === null) {
            header('Location:/connexion');
            return "";
        }

        $errors = $lexicon = [];
        $lexiconManager = new LexiconManager();
        $lexicon = $lexiconManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lexicon = array_map('trim', $_POST);
            $lexicon['id'] = $id;
            $errors = $this->lexiconValidate($lexicon);

            if (empty($errors)) {
                $lexiconManager->update($lexicon);
                header('Location: /admin/lexiques/');
            }
        }
        return $this->twig->render('Admin/Lexicon/edit.html.twig', [
            'lexicon' => $lexicon,
            'errors' => $errors
        ]);
    }

    public function deleteLexicon()
    {
        if ($this->getUser() === null) {
            header('Location:/connexion');
            return "";
        }

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

        if (empty($lexicon['definition'])) {
            $errors[] = 'Le champ definition est obligatoire';
        }
        return $errors;
    }
}
