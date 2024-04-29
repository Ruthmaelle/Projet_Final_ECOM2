<?php
session_start();
require_once('../classes/GestionProduct.php');
require_once('../DB/connexion.php');

if ($_SESSION['user_name'] !== 'SuperAdmin') {
    header('Location: login.php');
    exit();
}

$gestionOrder = new GestionProduct($dbco);
$orders = $gestionOrder->getAllOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Orders Management</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Total</th>
                <th>User ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']) ?></td>
                <td><?= htmlspecialchars($order['ref']) ?></td>
                <td><?= htmlspecialchars($order['date']) ?></td>
                <td>$<?= number_format($order['total'], 2) ?></td>
                <td><?= htmlspecialchars($order['user_id']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>