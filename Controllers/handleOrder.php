<?php
session_start();
require_once('../DB/connexion.php'); // Path to your database connection script

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['userID'], $data['total'], $data['orderID'])) {
    $userID = $data['userID'];
    $total = $data['total'];
    $orderID = $data['orderID'];
    $date = date('Y-m-d');

    // Prepare and execute the SQL
    $stmt = $dbco->prepare("INSERT INTO user_order (ref, date, total, user_id) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$orderID, $date, $total, $userID])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
}
?>
