<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index(): string
    {
        if ($this->getUser() === null) {
            header('Location:/connexion');
            return "";
        }

        return $this->twig->render('Admin/Home/index.html.twig');
    }
}
