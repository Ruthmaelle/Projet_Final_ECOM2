<?php
require_once("../DB/connexion.php");
require_once("../classes/GestionUser.php");
require_once("../classes/User.php");

class Validations {
    public function validateEmail($email) {
        $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);
        $message = $isValid ? '' : 'Format d\'email invalide';
        return new ValidationResult($isValid, $message);
    }

    public function validatePassword($password) {
        $isValid = (strlen($password) >= 6);
        $message = $isValid ? '' : 'Le mot de passe doit contenir au moins 6 caractères';
        return new ValidationResult($isValid, $message);
    }

    public function validateUsername($username) {
        $length = strlen($username);
        $isValid = ($length >= 5 && $length <= 20);
        $message = $isValid ? '' : 'Le nom d\'utilisateur doit avoir entre 5 et 20 caractères';
        return new ValidationResult($isValid, $message);
    }
}

class ValidationResult {
    public $isValid;
    public $message;

    public function __construct($isValid, $message) {
        $this->isValid = $isValid;
        $this->message = $message;
    }
}
?>


