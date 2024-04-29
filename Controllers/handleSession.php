<?php
session_start();

// Supprimer le panier de la session seulement après la confirmation de paiement
if (isset($_SESSION['payment_approved']) && $_SESSION['payment_approved'] === true) {
    unset($_SESSION['cart']);
    unset($_SESSION['payment_approved']); // Nettoyer la variable pour éviter des suppressions futures non désirées
}
?>
