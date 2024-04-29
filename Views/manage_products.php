<?php
session_start();
require_once('../DB/connexion.php');
require("../Controllers/functions.php");

if (!isset($_SESSION['user_name']) || $_SESSION['user_name'] !== 'SuperAdmin') {
    header('Location: login.php'); // Redirect non-SuperAdmins
    exit();
}

$listeProduits = getListProduit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        .product-img {
            width: 110px; /* Adjust size as needed */
            height: auto;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Product Management</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listeProduits as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><img src="../images/<?php echo $product['img_url']; ?>" alt="Product Image" class="product-img"></td>
                <td>
                    <a href="./edit_product.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">Modify</a>
                    <a href="../Controllers/delete_product.php?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>