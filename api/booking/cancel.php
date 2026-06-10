<?php

session_start();

header("Content-Type: application/json");

require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id'] ?? 0);

if (!$id) {
    echo json_encode([
        "success" => false,
        "message" => "Booking ID required"
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        UPDATE bookings
        SET booking_status = 'cancelled'
        WHERE id = :id AND user_id = :user_id
    ");

    $stmt->execute([
        ":id" => $id,
        ":user_id" => $_SESSION['user_id']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Booking cancelled successfully"
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}