<?php

namespace App\Controller;

use App\Model\UserManager;

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
            $userManager = new UserManager();
            $user = $userManager->selectOneByEmail($connexion['email']);
            if ($user) {
                if ($user['password'] === $connexion['password']) {
                    echo 'Les identifiants sont corrects';
                } else {
                    $errors[] = 'Mauvais identifiants';
                }
            } else {
                $errors[] = 'Email inconnu';
            }
            $_SESSION['user'] = $user['id'];
        }
        return $errors;
    }
}
