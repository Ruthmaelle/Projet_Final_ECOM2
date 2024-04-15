<?php
$server = 'localhost';
$db = 'ecom2_project';
$username = 'root';
$password = '';

try {
    $dbco = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //utiliser ma connexion
    echo "Connexion à la base de données réussie.";
}catch (PDOException $e){
    echo("Erreur de connexion : " .$e->getMessage());
}

?>