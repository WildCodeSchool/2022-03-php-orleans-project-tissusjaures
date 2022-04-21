<?php

namespace App\Model;

class FormVerification
{
    private array $errors = [];
    private array $contact = [];
    private int $nameMaxLength = 255;
    private int $phoneLength = 50;
    private int $emailMaxLength = 255;

    public function verification()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $contact = array_map("trim", $_POST);
        }
        if (empty($contact["firstname"])) {
            $errors[] = "Le prénom est obligatoire";
        }
        $nameMaxLength = 255;
        if (strlen($contact["firstname"]) > $nameMaxLength) {
            $errors[] = "Le prénom doit faire moins de " . $nameMaxLength . " caractères";
        }
        if (strlen($contact["lastname"]) > $nameMaxLength) {
            $errors[] = "Le prénom doit faire moins de " . $nameMaxLength . " caractères";
        }
        if (empty($contact["lastname"])) {
            $errors[] = "Le nom est obligatoire";
        }
        if (empty($contact["phone"])) {
            $errors[] = "Le numéro de téléphone est obligatoire";
        }
        $phoneLength = 50;
        if (strlen($contact["phone"]) > $phoneLength) {
            $errors[] = "Le numéro de téléphone doit faire moins de " . $phoneLength . " caractères";
        }
        if (empty($contact["email"])) {
            $errors[] = "Le email est obligatoire";
        }
        $emailMaxLength = 255;
        if (strlen($contact["email"]) > $emailMaxLength) {
            $errors[] = "Le mail doit faire moins de " . $emailMaxLength . "caractères";
        }
        if (!filter_var($contact['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Mauvais format pour l'email " . htmlentities($contact["email"]);
        }
        if (empty($contact["object"])) {
            $errors[] = "Le champ object est obligatoire";
        }
        if (empty($contact["message"])) {
            $errors[] = "n'oubliez pas votre message";
        }
    }
}
