<?php
session_start();
require_once("../DB/connexion.php");
require_once("../classes/GestionUser.php");

$gestionUser = new GestionUser($dbco);

if (!isset($_SESSION['user_name']) || $_SESSION['user_name'] !== 'SuperAdmin') {
    header('Location: login.php'); // Redirect non-SuperAdmins
    exit();
}

$users = $gestionUser->getAllUser();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>User Management</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['user_name']) ?></td>
                <td>
                    <a href="../Controllers/delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>