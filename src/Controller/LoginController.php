<?php

namespace App\Controller;

class LoginController extends AbstractController
{
    public function login(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
        }    
        return $this->twig->render('Login/login.html.twig');
    }
}
