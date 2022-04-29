<?php

namespace App\Controller;

class ContactController extends AbstractController
{
    protected const NAME_LENGTH = 100;
    protected const PHONE_LENGTH = 50;

    public function index(): string
    {
        $errorsEmpty = [];
        $errorsFormat = [];
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $contact = array_map("trim", $_POST);
            $errorsEmpty = $this->validate($contact);
            $errorsFormat = $this->validateFormat($contact);
            $errors = [...$errorsEmpty, ...$errorsFormat];
        }
        return $this->twig->render('contact.html.twig', [
            'errors' => $errors,
        ]);
    }

    private function validate(array $contact): array
    {
        $errorsEmpty = [];
        if (empty($contact["firstname"])) {
            $errorsEmpty[] = "Le prénom est obligatoire";
        }

        if (empty($contact["lastname"])) {
            $errorsEmpty[] = "Le nom est obligatoire";
        }

        if (empty($contact["phone"])) {
            $errorsEmpty[] = "Le numéro de téléphone est obligatoire";
        }

        if (empty($contact["email"])) {
            $errorsEmpty[] = "L'email est obligatoire";
        }

        if (empty($contact["message"])) {
            $errorsEmpty[] = "N'oubliez pas votre message";
        }
        return $errorsEmpty;
    }

    private function validateFormat(array $contact): array
    {
        $errorsFormat = [];
        if (strlen($contact["firstname"]) > self::NAME_LENGTH) {
            $errorsFormat[] = "Le prénom doit faire moins de " . self::NAME_LENGTH . " caractères";
        }
        if (strlen($contact["lastname"]) > self::NAME_LENGTH) {
            $errorsFormat[] = "Le prénom doit faire moins de " . self::NAME_LENGTH . " caractères";
        }

        if (strlen($contact["phone"]) > self::PHONE_LENGTH) {
            $errorsFormat[] = "Le numéro de téléphone doit faire moins de " . self::PHONE_LENGTH . " caractères";
        }

        if (!filter_var($contact['email'], FILTER_VALIDATE_EMAIL)) {
            $errorsFormat[] = "Mauvais format pour l'email " . $contact["email"];
        }
        return $errorsFormat;
    }
}
