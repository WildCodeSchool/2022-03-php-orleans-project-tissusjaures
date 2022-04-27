<?php

namespace App\Controller;

class ContactController extends AbstractController
{
    protected const NAME_LENGTH = 255;
    protected const PHONE_LENGTH = 50;
    public function index(): string
    {
        $errors = null;
        $errorsTwo = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $contact = array_map("trim", $_POST);
            $errors = $this->validate($contact);
            $errorsTwo = $this->validateFormat($contact);
        }
        return $this->twig->render('contact.html.twig', ['errors' => $errors, 'errorsTwo' => $errorsTwo]);
    }

    private function validate(array $contact): array
    {
        $errors = [];

        if (empty($contact["firstname"])) {
            $errors[] = "Le prénom est obligatoire";
        }


        if (empty($contact["lastname"])) {
            $errors[] = "Le nom est obligatoire";
        }
        if (empty($contact["phone"])) {
            $errors[] = "Le numéro de téléphone est obligatoire";
        }


        if (empty($contact["email"])) {
            $errors[] = "Le email est obligatoire";
        }

        if (empty($contact["message"])) {
            $errors[] = "N'oubliez pas votre message";
        }

        return $errors;
    }
    private function validateFormat(array $contact): array
    {
        $errorsTwo = [];

        if (strlen($contact["firstname"]) > self::NAME_LENGTH) {
            $errorsTwo[] = "Le prénom doit faire moins de " . self::NAME_LENGTH . " caractères";
        }
        if (strlen($contact["lastname"]) > self::NAME_LENGTH) {
            $errorsTwo[] = "Le prénom doit faire moins de " . self::NAME_LENGTH . " caractères";
        }

        if (strlen($contact["phone"]) > self::PHONE_LENGTH) {
            $errorsTwo[] = "Le numéro de téléphone doit faire moins de " . self::PHONE_LENGTH . " caractères";
        }
        if (!filter_var($contact['email'], FILTER_VALIDATE_EMAIL)) {
            $errorsTwo[] = "Mauvais format pour l'email " . $contact["email"];
        }
        return $errorsTwo;
    }
}
