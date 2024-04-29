<?php
session_start();
require_once("../DB/connexion.php");  // Assurez-vous que la connexion est correcte
require_once("../classes/GestionUser.php");

$productId = $_POST['productId'];
$quantity = $_POST['quantity'];

if ($quantity <= 0) {
    unset($_SESSION['cart'][$productId]);
} else {
    $_SESSION['cart'][$productId]['quantity'] = $quantity;
}

// Recalculate total price
$totalPrice = 0;
foreach ($_SESSION['cart'] as $id => $product) {
    $totalPrice += $product['price'] * $product['quantity'];
}

echo json_encode(['status' => 'success', 'newTotal' => $totalPrice]);
?>
