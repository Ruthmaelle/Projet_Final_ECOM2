<?php
session_start();
if (!isset($_SESSION['user_name']) || $_SESSION['user_name'] !== 'SuperAdmin') {
    header('Location: login.php'); // Redirect to login if not SuperAdmin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!--Font_Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
    <div>
        <a href="./logout.php" class="d-flex align-items-center text-decoration-none" aria-label="Logout">
        <i class="fa-solid fa-arrow-right-from-bracket" ></i>
        </a>
        </div>
        <h1>Admin Panel</h1>
        <div class="list-group">
            <a href="./manage_products.php" class="list-group-item list-group-item-action">Manage Products</a>
            <a href="manage_orders.php" class="list-group-item list-group-item-action">Manage Orders</a>
            <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
        </div>
        
    </div>
</body>
</html>