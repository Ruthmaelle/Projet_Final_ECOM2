<?php
session_start();
require_once('../DB/connexion.php');

if ($_SESSION['user_name'] !== 'SuperAdmin' || !isset($_GET['id'])) {
    header('Location: ../Views/login.php');
    exit();
}

$id = $_GET['id'];
$stmt = $dbco->prepare('DELETE FROM user WHERE id = :id');
$stmt->execute(['id' => $id]);

header('Location: ../Views/manage_users.php');
exit();
