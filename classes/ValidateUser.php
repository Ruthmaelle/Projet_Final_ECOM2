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



<!--comment l'appeler dans une autre page
<php
require_once('Validator.php');

// Validation d'une adresse e-mail
$email = "user@example.com";
if (Validator::validateEmail($email)) {
    echo "Adresse e-mail valide";
} else {
    echo "Adresse e-mail non valide";
}

// Validation d'un mot de passe
$password = "password123";
if (Validator::validatePassword($password)) {
    echo "Mot de passe valide";
} else {
    echo "Mot de passe non valide";
}
?>
-->
