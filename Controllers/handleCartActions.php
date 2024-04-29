<?php
session_start();
require("../DB/connexion.php");
require("../Controllers/functions.php");
require("../classes/GestionUser.php");

$gestionUser = new GestionUser($dbco);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'], $_POST['quantity'])) {
    $productId = intval($_POST['productId']);
    $quantity = intval($_POST['quantity']);

    $response = $gestionUser->addToCart($productId, $quantity);
    echo json_encode($response);
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
