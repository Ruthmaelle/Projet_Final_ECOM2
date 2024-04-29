<?php
$server = 'localhost';
$db = 'ecom2_project';
$username = 'root';
$password = '';

try {
    $dbco = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbco;
    //utiliser ma connexion
    echo "";
}catch (PDOException $e){
    echo("Erreur de connexion : " .$e->getMessage());
}

?>