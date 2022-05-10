<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index(): string
    {
        if ($this->getUser() === null) {
            header('HTTP/1.0 403 Forbidden');
            return "Vous n'êtes pas autorisé à visiter cette page.";
        }

        return $this->twig->render('Admin/Home/index.html.twig');
    }
}
