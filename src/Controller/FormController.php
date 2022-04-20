<?php

namespace App\Controller;

class FormController extends AbstractController
{
    public function form(): string
    {
        return $this->twig->render('form.html.twig');
    }
}