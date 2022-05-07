<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Admin/Home/index.html.twig');
    }
}
