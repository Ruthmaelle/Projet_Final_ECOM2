<?php
session_start();
require_once('../DB/connexion.php');

if ($_SESSION['user_name'] !== 'SuperAdmin' || !isset($_GET['id'])) {
    header('Location: ../Views/login.php');
    exit();
}

$id = $_GET['id'];
$stmt = $dbco->prepare('DELETE FROM product WHERE id = :id');
$stmt->execute(['id' => $id]);

header('../Views/manage_products.php');
exit();
