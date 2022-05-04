<?php

namespace App\Controller;

class LoginController extends AbstractController
{
    public function login(): string
    {
        $errors = [];
        $connexion = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $connexion = array_map('trim', $_POST);
            $errors = $this->validate($connexion);
        }
        return $this->twig->render('Login/login.html.twig', [
            'errors' => $errors,
        ]);
    }

    private function validate(array $connexion): array
    {
        $errors = [];
        if (empty($connexion['email'])) {
            $errors[] = 'Le champ email ne doit pas être vide';
        }
        if (empty($connexion['password'])) {
            $errors[] = 'Le mot de passe ne doit pas être vide';
        }
        if (!filter_var($connexion['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "format d'email invalide";
        }
        if (empty($errors)) {
            //tentative de login
        }
        return $errors;
    }
}
